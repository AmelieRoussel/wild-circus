<?php

namespace App\Controller;

use App\Entity\Performance;
use App\Form\PerformanceType;
use App\Repository\PerformanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/performance", name="admin_performance_")
 */
class AdminPerformanceController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     * @param PerformanceRepository $performanceRepository
     * @return Response
     */
    public function index(PerformanceRepository $performanceRepository): Response
    {
        return $this->render('admin/performance/index.html.twig', [
            'performances' => $performanceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/ajout", name="new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $performance = new Performance();
        $form = $this->createForm(PerformanceType::class, $performance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($performance);
            $entityManager->flush();

            $this->addFlash('success', 'La performance a bien été ajoutée.');

            return $this->redirectToRoute('admin_performance_index');
        }

        return $this->render('admin/performance/new.html.twig', [
            'performance' => $performance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param Performance $performance
     * @return Response
     */
    public function show(Performance $performance): Response
    {
        return $this->render('admin/performance/show.html.twig', [
            'performance' => $performance,
        ]);
    }

    /**
     * @Route("/{id}/edition", name="edit", methods={"GET","POST"})
     * @param Request $request
     * @param Performance $performance
     * @return Response
     */
    public function edit(Request $request, Performance $performance): Response
    {
        $form = $this->createForm(PerformanceType::class, $performance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'La performance a bien été modifiée.');

            return $this->redirectToRoute('admin_performance_index');
        }

        return $this->render('admin/performance/edit.html.twig', [
            'performance' => $performance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Request $request
     * @param Performance $performance
     * @return Response
     */
    public function delete(Request $request, Performance $performance): Response
    {
        if ($this->isCsrfTokenValid('delete'.$performance->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($performance);
            $entityManager->flush();
        }

        $this->addFlash('danger', 'La performance a été supprimée.');

        return $this->redirectToRoute('admin_performance_index');
    }
}
