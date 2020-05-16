<?php

namespace App\Controller;

use App\Repository\VilleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NcVilleController extends AbstractController
{
    /**
     * @Route("/nc/ville", name="nc_ville")
     */
    public function index(VilleRepository $villeEntityRepository)
    {
        $lesVilles=$villeEntityRepository->findAll();
        return $this->render('nc_ville/index.html.twig', [
            'controller_name' => 'NcVilleController',
            'lesVilles' => $lesVilles
        ]);
    }
}
