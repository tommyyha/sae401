<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ModifyProfileController extends AbstractController
{
    #[Route('/modify/profile', name: 'app_modify_profile')]
    public function modifier(Request $request, UserInterface $user, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(UtilisateurType::class, $user);
        $form->handleRequest($request);
        $user = $this->getUser(); 
        $file = $form->get('profilePicture')->getData();
        $file2 = $form->get('coverPhoto')->getData();

        if ($form->isSubmitted() && $form->isValid()) {
            $profilePicture = $form->get('profilePicture')->getData();
            if ($profilePicture) {
                $fileExtension = $file->guessExtension();
                $newFilename = "ProfilePicture_" . $user->getId() . "." . $fileExtension;
                $user->setProfilePicture($newFilename); // Assurez-vous d'avoir un setter approprié dans votre entité
                try {
                    $profilePicture->move(
                        $this->getParameter('uploads_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
            }

            $coverPhoto = $form->get('coverPhoto')->getData();
            if ($coverPhoto) {
                $fileExtension2 = $file2->guessExtension();
                $newFilename = "CoverPhoto_" . $user->getId() . "." . $fileExtension;
                $user->setProfileCover($newFilename); // Assurez-vous d'avoir un setter approprié dans votre entité
                try {
                    $coverPhoto->move(
                        $this->getParameter('uploads_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
            }

            $entityManager->flush();
            return $this->redirectToRoute('app_utilisateur');
        }

        return $this->render('modify_profile/index.html.twig', [
            'utilisateurForm' => $form->createView(),
        ]);
    }

}
