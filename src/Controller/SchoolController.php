<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SchoolController extends AbstractController
{
    /**
     * @Route("/ecole", name="school_home", methods={"GET"})
     * @return Response
     */
    public function index(): Response
    {
        $this->addFlash('danger', 'En raison de la crise sanitaire, l\'école n\'a pas pu ouvrir cette année.');

        return $this->render('school/index.html.twig');
    }
}