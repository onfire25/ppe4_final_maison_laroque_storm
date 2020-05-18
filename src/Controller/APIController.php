<?php


namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produit;

/**
 * @Route("/API")
 */
class APIController extends AbstractController
{
    /**
     * @Route("/produit/show", name="produitAPI_show", methods={"GET"})
     */
    public function produitAPI(){
        $produits = $this->getDoctrine()
            ->getRepository(Produit::class)
            ->findAll();
        $contenu = [];
        foreach ($produits as $produit){
            $contenu[] = [
                "id" => $produit->getId(),
                "libelle" => $produit->getLibelle(),
                "description" => $produit->getDescription(),
                "prixht" => $produit->getPrixht(),
                "stock" => $produit->getStock()
            ];
        }
        $contenu = '{"produits":'.json_encode($contenu).'}';
        return new Response($contenu, 200, array(
            'Content-Type' => 'application/json'
        ));
    }

    /**
     * @Route("/utilisateur/show", name="utilisateurAPI_show", methods={"GET"})
     */
    public function utilisateurAPI(){
        $utilisateurs = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();
        $contenu = [];
        foreach ($utilisateurs as $utilisateur){
            $contenu[] = [
                "id" => $utilisateur->getId(),
                "email" => $utilisateur->getEmail(),
                "password" => $utilisateur->getPassword(),
                "roles" => $utilisateur->getRoles(),
                "nom" => $utilisateur->getNom(),
                "prenom" => $utilisateur->getPrenom()
            ];
        }
        $contenu = '{"utilisateurs":'.json_encode($contenu).'}';
        return new Response($contenu, 200, array(
            'Content-Type' => 'application/json'
        ));
    }
}