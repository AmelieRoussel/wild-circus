<?php

namespace App\Controller;

use App\Entity\Show;
use App\Form\ShowType;
use App\Repository\ShowRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/tarifs", name="admin_show_")
 */
class AdminShowController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     * @param ShowRepository $showRepository
     * @return Response
     */
    public function index(ShowRepository $showRepository): Response
    {
        return $this->render('admin/show/index.html.twig', [
            'shows' => $showRepository->findAll(),
        ]);
    }

    /**
     * @Route("/ajout", name="new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $show = new Show();
        $form = $this->createForm(ShowType::class, $show);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($show);
            $entityManager->flush();

            $this->addFlash('success', 'Le tarif a bien été ajouté.');

            return $this->redirectToRoute('admin_show_index');
        }

        return $this->render('admin/show/new.html.twig', [
            'show' => $show,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edition", name="edit", methods={"GET","POST"})
     * @param Request $request
     * @param Show $show
     * @return Response
     */
    public function edit(Request $request, Show $show): Response
    {
        $form = $this->createForm(ShowType::class, $show);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Le tarif a bien été modifié.');

            return $this->redirectToRoute('admin_show_index');
        }

        return $this->render('admin/show/edit.html.twig', [
            'show' => $show,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Request $request
     * @param Show $show
     * @return Response
     */
    public function delete(Request $request, Show $show): Response
    {
        if ($this->isCsrfTokenValid('delete'.$show->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($show);
            $entityManager->flush();
        }

        $this->addFlash('danger', 'Le tarif a été supprimé.');

        return $this->redirectToRoute('admin_show_index');
    }
}
