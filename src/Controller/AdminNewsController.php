<?php

namespace App\Controller;

use App\Entity\News;
use App\Form\NewsType;
use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/actualites", name="admin_news_")
 */
class AdminNewsController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     * @param NewsRepository $newsRepository
     * @return Response
     */
    public function index(NewsRepository $newsRepository): Response
    {
        return $this->render('admin/news/index.html.twig', [
            'news' => $newsRepository->findBy([], ['id' => 'DESC']),
        ]);
    }

    /**
     * @Route("/ajout", name="new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $news = new News();
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($news);
            $entityManager->flush();

            $this->addFlash('success', 'L\'actualité a bien été ajoutée.');

            return $this->redirectToRoute('admin_news_index');
        }

        return $this->render('admin/news/new.html.twig', [
            'news' => $news,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id<^[0-9]+$>}", name="show", methods={"GET"})
     * @param News $news
     * @return Response
     */
    public function show(News $news): Response
    {
        return $this->render('admin/news/show.html.twig', [
            'news' => $news,
        ]);
    }

    /**
     * @Route("/{id<^[0-9]+$>}/edition", name="edit", methods={"GET","POST"})
     * @param Request $request
     * @param News $news
     * @return Response
     */
    public function edit(Request $request, News $news): Response
    {
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'L\'actualité a bien été modifiée.');

            return $this->redirectToRoute('admin_news_index');
        }

        return $this->render('admin/news/edit.html.twig', [
            'news' => $news,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id<^[0-9]+$>}", name="delete", methods={"DELETE"})
     * @param Request $request
     * @param News $news
     * @return Response
     */
    public function delete(Request $request, News $news): Response
    {
        if ($this->isCsrfTokenValid('delete'.$news->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($news);
            $entityManager->flush();
        }

        $this->addFlash('danger', 'L\'actualité a été supprimée.');

        return $this->redirectToRoute('admin_news_index');
    }
}
