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
}