<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET", "POST"})
     * @param Request $request
     * @param MailerInterface $mailer
     * @return Response
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new Email())
                ->from($contact->getEmail())
                ->to($this->getParameter('mailer_admin'))
                ->subject($contact->getSubject())
                ->html($this->renderView('contact/contactEmail.html.twig', ['contact' => $contact]));
            $mailer->send($email);

            $this->addFlash('success', 'Votre message a bien été envoyé.');

            return $this->redirectToRoute('home');
        }

        return $this->render('home/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin", name="admin_home", methods={"GET"})
     * @return Response
     */
    public function admin(): Response
    {
        return $this->render('admin/home/index.html.twig');

    }
}