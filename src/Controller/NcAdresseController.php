<?php

namespace App\Controller;

use App\Repository\AdresseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NcAdresseController extends AbstractController
{
    /**
     * @Route("/nc/adresse", name="nc_adresse")
     */
    public function index(AdresseRepository $adresseEntityRepository)
    {
        $lesAdresses=$adresseEntityRepository->ncFindPerso1();
        return $this->render('nc_adresse/index.html.twig', [
            'controller_name' => 'NcAdresseController',
            'lesAdresses' => $lesAdresses
        ]);
    }

    /**
     * @Route("/nc/adresse2", name="nc_adresse_2")
     */
    public function index2(AdresseRepository $adresseEntityRepository)
    {
        dump($adresseEntityRepository->ncFindPerso2());
        die;
    }

    /**
     * @Route("/nc/adresse3", name="nc_adresse_3")
     */
    public function index3(AdresseRepository $adresseEntityRepository)
    {
        dump($adresseEntityRepository->ncFindPerso3());
        die;
    }

    /**
     * @Route("/nc/adresseDql1", name="nc_adresse_4")
     */
    public function indexDql1(AdresseRepository $adresseEntityRepository)
    {
        dump($adresseEntityRepository->ncFindAdresseDql1());
        die;
    }

    /**
     * @Route("/nc/adresseDql2", name="nc_adresse_6")
     */
    public function indexDql2(AdresseRepository $adresseEntityRepository)
    {
        dump($adresseEntityRepository->ncFindAdresseDql2());
        die;
    }

    /**
     * @Route("/nc/adresseDql3", name="nc_adresse_7")
     */
    public function indexDql3(AdresseRepository $adresseEntityRepository)
    {
        $lesAdresses=$adresseEntityRepository->ncFindAdresseDql3();
        dump($lesAdresses);
        /*die;*/
        return $this->render('nc_adresse/index2.html.twig', [
            'controller_name' => 'NcAdresseController',
            'lesAdresses' => $lesAdresses
        ]);
    }

}
