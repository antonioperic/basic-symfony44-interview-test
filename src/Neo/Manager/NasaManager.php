<?php


namespace App\Neo\Manager;


use App\Neo\Entity\Neo;
use App\Neo\Factory\NeoFactory;
use App\Neo\Nasa\NasaService;
use App\Neo\Repository\NeoRepository;

class NasaManager
{
    /**
     * @var NasaService
     */
    private $nasaService;

    /**
     * @var NeoRepository
     */
    private $neoRepository;

    public function __construct(NasaService $nasaService, NeoRepository $neoRepository)
    {
        $this->nasaService = $nasaService;
        $this->neoRepository = $neoRepository;
    }

    public function updateFeed(string $since = '-3days'): void
    {
        $data = $this->nasaService->getFeed($since);

        $this->processFeed($data);
    }

    private function processFeed(array $feed): void
    {
        foreach ($feed['near_earth_objects'] as $date => $dataList) {
            if ($this->isDateInFuture($date)) {
                continue;
            }

            foreach ($dataList as $data) {
                $dateTime = new \DateTime($date);

                $neo = $this->neoRepository->findOneByDateAndReference($dateTime, $data['neo_reference_id']);

                if ($neo instanceof Neo) {
                    continue;
                }

                $neo = NeoFactory::create(
                    $dateTime,
                    $data['neo_reference_id'],
                    $data['name'],
                    $data['close_approach_data'][0]['relative_velocity']['kilometers_per_hour'],
                    $data['is_potentially_hazardous_asteroid']
                );

                $this->neoRepository->save($neo);
            }
        }

        if ($this->isNextAvailable($feed)) {
            $feed = $this->nasaService->getFeedByUrl($feed['links']['next']);
            $this->processFeed($feed);
        }
    }

    /** if date is in future we don't need to parse links anymore, or if date with data is in future we don't need that data */
    private function isNextAvailable(array $feed): bool
    {
        $url = parse_url($feed['links']['next']);
        parse_str($url['query'], $output);

        return !$this->isDateInFuture($output['start_date']);
    }

    private function isDateInFuture(string $date): bool
    {
        $date = new \DateTime($date);
        $nowDate = new \DateTime();

        if ($date > $nowDate) {
            return true;
        }

        return false;
    }
}