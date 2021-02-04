<?php

namespace App\Controller;

use App\Entity\Member;
use App\Entity\User;
use App\Form\EnrollmentType;
use App\Repository\CourseRepository;
use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ecole", name="school_")
 * Class SchoolController
 * @package App\Controller
 */
class SchoolController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     * @param CourseRepository $courseRepository
     * @return Response
     */
    public function index(CourseRepository $courseRepository): Response
    {
        $this->addFlash('danger', 'En raison de la crise sanitaire, l\'école n\'a pas pu ouvrir cette année.');

        return $this->render('school/index.html.twig', [
            'courses' => $courseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/inscription", name="enrollment", methods={"GET", "POST"})
     * @param Request $request
     * @return Response
     */
    public function enrollment(Request $request):Response
    {
        $member = new Member();
        $form = $this->createForm(EnrollmentType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            /** @var User $user */
            $user = $this->getUser();
            $member->setUser($user);
            if (!in_array("ROLE_MEMBER", $user->getRoles())) {
                $user->setRoles(["ROLE_MEMBER"]);
            }
            $entityManager->persist($member);
            $entityManager->flush();
            $this->addFlash('success', 'Votre inscription a bien été prise en compte.');

            return $this->redirectToRoute('school_home');
        }

        return $this->render('school/enrollment.html.twig', [
            'form' => $form->createView()
        ]);

    }
}