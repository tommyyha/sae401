<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\EcoScoreQuestionnaireType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Utilisateur; // Assurez-vous d'avoir votre entité Utilisateur

class EcoScoreQuestionnaireController extends AbstractController
{
    #[Route('/eco-questionnaire', name: 'eco_questionnaire')]
    public function index(Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(EcoScoreQuestionnaireType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $ecoScore = array_sum(array_values($data)); // Calcul simple pour l'exemple

            // Ici, vous devez enregistrer l'éco-score pour l'utilisateur connecté
            $user = $this->getUser(); // Obtenez l'utilisateur connecté
            if ($user) {
                $user->setEcoScore($ecoScore); // Mettez à jour l'éco-score de l'utilisateur
                
                // Utilisez directement l'EntityManager injecté
                $entityManager->persist($user);
                $entityManager->flush();

                // Redirigez l'utilisateur vers son profil ou affichez un message
                $this->addFlash('success', 'Votre éco-score a été mis à jour.');
                return $this->redirectToRoute('app_profil', ['username' => $user->getUsername()]);
            }
        }

        return $this->render('eco_score_questionnaire/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
