<?php

namespace App\Controller;

use App\services\GeoApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CoursServiceRequestController extends AbstractController
{
    public function __construct(
        private GeoApiService $geoApiService
    )
    {
    }

    #[Route('/cours', name: 'app_cours_service_request')]
    public function index(): Response
    {
//        dump($this->geoApiService->test());

        $regions = $this->geoApiService->getAllRegions();
        dump($regions);

        return $this->render('cours_service_request/index.html.twig', [
            'controller_name' => 'Ceci est une révision de Symfony',
        ]);
    }
}
