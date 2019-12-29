<?php


namespace App\Neo\Controller;


use App\Neo\Repository\NeoRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class NeoController
{
    /**
     * @var NeoRepository
     */
    private $neoRepository;

    public function __construct(NeoRepository $neoRepository)
    {
        $this->neoRepository = $neoRepository;
    }

    /**
     * @Route("/neo/hazardous", name="neo_hazardous")
     */
    public function getHazardous(): JsonResponse
    {
        $hazardous = $this->neoRepository->findAllHazardous();

        return new JsonResponse($hazardous);
    }

    /**
     * @Route("/neo/fastest/{hazardous}", name="neo_fastest", defaults={"hazardous"=false})
     */
    public function getFastest($hazardous = false): JsonResponse
    {
        $neo = $this->neoRepository->findFastest($hazardous);

        return new JsonResponse(
            [
                'id' => $neo->getId(),
                'date' => $neo->getDate()->format('y-m-d'),
                'reference' => $neo->getReference(),
                'name' => $neo->getName(),
                'speed' => $neo->getSpeed(),
                'hazardous' => $neo->getIsHazardous(),
            ]
        );
    }

    /**
     * @Route("/neo/best-year/{hazardous}", name="neo_best_year", defaults={"hazardous"=false})
     */
    public function getBestYear($hazardous = false): JsonResponse
    {
        $bestYear = $this->neoRepository->findBestYear($hazardous);

        return new JsonResponse(
            [
                'year' => $bestYear[0]['gYear'],
                'total' => $bestYear[0]['count'],
            ]
        );
    }

    /**
     * @Route("/neo/best-month/{hazardous}", name="neo_best_month", defaults={"hazardous"=false})
     */
    public function getBestMonth($hazardous = false): JsonResponse
    {
        $bestYear = $this->neoRepository->findBestMonth($hazardous);

        return new JsonResponse(
            [
                'year' => $bestYear[0]['gYear'],
                'month' => $bestYear[0]['gMonth'],
                'total' => $bestYear[0]['count'],
            ]
        );
    }
}