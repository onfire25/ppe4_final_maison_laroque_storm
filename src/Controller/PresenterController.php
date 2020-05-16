<?php

namespace App\Controller;

use App\Entity\Presenter;
use App\Form\PresenterType;
use App\Repository\PresenterRepository;
use App\Repository\ProduitRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/presenter")
 */
class PresenterController extends AbstractController
{
    /**
     * @Route("/", name="presenter_index", methods={"GET"})
     * @param PresenterRepository $presenterRepository
     * @return Response
     */
    public function index(PresenterRepository $presenterRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, "Vous n'avez pas les droits d'accès a cette page !");
        return $this->render('presenter/index.html.twig', [
            'presenters' => $presenterRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="presenter_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, "Vous n'avez pas les droits d'accès a cette page !");
        $presenter = new Presenter();
        $form = $this->createForm(PresenterType::class, $presenter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($presenter);
            $entityManager->flush();

            return $this->redirectToRoute('presenter_index');
        }

        return $this->render('presenter/new.html.twig', [
            'presenter' => $presenter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}-{id}", name="presenter_show", requirements={"slug": "[a-z0-9-]*"}, methods={"GET"})
     * @param Presenter $presenter
     * @param string $slug
     * @return Response
     */
    public function show(Presenter $presenter, string $slug): Response
    {
        if($presenter->getSlug()!==$slug){
            return $this->redirectToRoute('property.show',[
                'id' => $presenter->getId(),
                'slug' => $presenter->getSlug()
            ],301);
        }
        return $this->render('presenter/show.html.twig', [
            'presenter' => $presenter,
            'current_menu' => 'presenter'
        ]);
    }

    /**
     * @Route("/{id}/edit", name="presenter_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Presenter $presenter
     * @return Response
     */
    public function edit(Request $request, Presenter $presenter): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, "Vous n'avez pas les droits d'accès a cette page !");
        $form = $this->createForm(PresenterType::class, $presenter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('presenter_index');
        }

        return $this->render('presenter/edit.html.twig', [
            'presenter' => $presenter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="presenter_delete", methods={"DELETE"})
     * @param Request $request
     * @param Presenter $presenter
     * @return Response
     */
    public function delete(Request $request, Presenter $presenter): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, "Vous n'avez pas les droits d'accès a cette page !");
        if ($this->isCsrfTokenValid('delete'.$presenter->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($presenter);
            $entityManager->flush();
        }

        return $this->redirectToRoute('presenter_index');
    }

    /**
     * @Route("/index/shop", name="afficher")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @param ProduitRepository $produitEntityRepository
     * @return Response
     */
    public function indexShop(PaginatorInterface $paginator, Request $request, ProduitRepository $produitEntityRepository): Response
    {
        $lesPresentations=$paginator->paginate(
            $produitEntityRepository->indexFindShop(),
            $request->query->getInt('page', 1),
            2
        );
        /*dump($lesPresentations);*/
        /*die;*/
        return $this->render('presenter/indexShow.html.twig', [
            'controller_presenter' => 'Presenter',
            'lesPresentations' => $lesPresentations
        ]);
    }

    /*public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $properties = $paginator->paginate(
            $this->repository->findAllVisibleQuery(),
            $request->query->getInt('page', 1),
            12
        );
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
            'properties' => $properties
        ]);
    }*/
}
