<?php

namespace App\Controller;

use App\Entity\News;
use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    /**
     * @Route("/actualites", name="news", methods={"GET"})
     * @param NewsRepository $newsRepository
     * @return Response
     */
    public function news(NewsRepository $newsRepository): Response
    {
        return $this->render('news/index.html.twig', [
            'news' => $newsRepository->findBy([], ['id' => 'DESC']),
        ]);
    }

    /**
     * @Route("/actualites/{id<^[0-9]+$>}", name="news_show", methods={"GET"})
     * @param News $news
     * @return Response
     */
    public function new(News $news): Response
    {
        return $this->render('news/news.html.twig', [
            'news' => $news,
        ]);
    }
}