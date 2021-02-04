<?php

namespace App\Controller;

use App\Entity\Member;
use App\Form\MemberType;
use App\Repository\MemberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/member", name="admin_member_")
 */
class MemberController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     * @param MemberRepository $memberRepository
     * @return Response
     */
    public function index(MemberRepository $memberRepository): Response
    {
        return $this->render('admin/member/index.html.twig', [
            'members' => $memberRepository->findBy([], ['lastname' => 'ASC', 'firstname' => 'ASC']),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $member = new Member();
        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($member);
            $entityManager->flush();

            $this->addFlash('success', 'Le membre a bien été ajouté.');

            return $this->redirectToRoute('admin_member_index');
        }

        return $this->render('admin/member/new.html.twig', [
            'member' => $member,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param Member $member
     * @return Response
     */
    public function show(Member $member): Response
    {
        return $this->render('admin/member/show.html.twig', [
            'member' => $member,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * @param Request $request
     * @param Member $member
     * @return Response
     */
    public function edit(Request $request, Member $member): Response
    {
        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Le membre a bien été modifié.');

            return $this->redirectToRoute('admin_member_index');
        }

        return $this->render('admin/member/edit.html.twig', [
            'member' => $member,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Request $request
     * @param Member $member
     * @return Response
     */
    public function delete(Request $request, Member $member): Response
    {
        if ($this->isCsrfTokenValid('delete'.$member->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($member);
            $entityManager->flush();
        }

        $this->addFlash('danger', 'Le membre a été supprimé.');

        return $this->redirectToRoute('admin_member_index');
    }
}
