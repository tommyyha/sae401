<?php

// src/Controller/ContactController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactFormType;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();

            $email = (new Email())
                ->from($contactFormData['email'])
                ->to('adem.ben-khedher@etudiant.univ-reims.fr')
                ->subject('Message du formulaire de contact')
                ->text("Envoyé par : ".$contactFormData['email']."\n\nMessage : ".$contactFormData['message']);

            $mailer->send($email);


            $this->addFlash('success', 'Votre message a été envoyé.');

            // Gardez l'utilisateur sur la même page
            return $this->render('contact/index.html.twig', [
                'contact_form' => $form->createView(),
                'message_sent' => true, // Vous pouvez utiliser cette variable pour afficher un message de confirmation dans votre vue.
            ]);
        }
    

        return $this->render('contact/index.html.twig', [
            'contact_form' => $form->createView(),
        ]);
    }
}
