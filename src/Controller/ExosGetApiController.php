<?php

namespace App\Controller;

use App\services\GeoApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ExosGetApiController extends AbstractController
{
    public function __construct(
        private GeoApiService $geoApiService
    )
    {
    }

    #[Route('/regions', name: 'regions')]
    public function getAllReg(): Response
    {
        $regions = $this->geoApiService->getAllRegions();
        dump($regions);

        return $this->render('exos_get_api/regions.html.twig', [
            'regions' => $regions,
        ]);
    }

    #[Route('/region/{codeReg}/departements', name: 'depByReg')]
    public function getDepByReg($codeReg): Response
    {
        $departements = $this->geoApiService->getDepByReg($codeReg);
        $region = $this->geoApiService->getRegion($codeReg);

        return $this->render('exos_get_api/departementsByRegion.html.twig', [
            'departements' => $departements,
            'region' => $region,
        ]);
    }

    #[Route('departement/{codeDep}/communes', name: 'comByDep')]
    public function getComByDep($codeDep): Response
    {
        $communess = $this->geoApiService->getComByDep($codeDep);
        $departement = $this->geoApiService->getDepartement($codeDep);

        return $this->render('exos_get_api/communesByDepartement.html.twig', [
            'communes' => $communess,
            'departement' => $departement,
        ]);
    }
}
