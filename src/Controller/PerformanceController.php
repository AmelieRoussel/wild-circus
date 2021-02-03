<?php

namespace App\Controller;

use App\Repository\PerformanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PerformanceController extends AbstractController
{
    /**
     * @Route("/performances", name="performance", methods={"GET"})
     * @param PerformanceRepository $performanceRepository
     * @return Response
     */
    public function index(PerformanceRepository $performanceRepository): Response
    {
        return $this->render('performance/index.html.twig', [
            'performances' => $performanceRepository->findAll(),
        ]);

    }
}