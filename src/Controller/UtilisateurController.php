<?php


namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\PublicationRepository; // Assurez-vous d'importer le PublicationRepository
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;
use App\Repository\FollowRepository; // Importez FollowRepository

class UtilisateurController extends AbstractController
{
    #[Route('/utilisateur', name: 'app_utilisateur')]
    public function profil(PublicationRepository $publicationRepository, Security $security, FollowRepository $followRepository): Response
    {
        $utilisateur = $security->getUser();
        
        if (!$utilisateur) {
            return $this->redirectToRoute('app_login');
        }

        $publications = $publicationRepository->findBy(['UserID' => $utilisateur->getId()], ['DateTime' => 'DESC']);
        
        foreach ($publications as $publication) {
            $filename = $publication->getPostContent();
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif'])) {
                $publication->fileType = 'image';
            } elseif (in_array(strtolower($extension), ['mp4', 'avi', 'mov'])) {
                $publication->fileType = 'video';
            } else {
                $publication->fileType = 'unknown';
            }
        }

        $followersCount = $followRepository->countFollowersOfUser($utilisateur);
        $followingsCount = $followRepository->countFollowingsOfUser($utilisateur);
        $followers = $followRepository->findFollowersOfUser($utilisateur);
        $followings = $followRepository->findFollowingsOfUser($utilisateur);
        $nombrePublications = $publicationRepository->countPublicationsByUser($utilisateur->getId());


        return $this->render('utilisateur/index.html.twig', [
            'utilisateur' => $utilisateur,
            'publications' => $publications,
            'followersCount' => $followersCount,
            'followingsCount' => $followingsCount,
            'followers' => $followers,
            'followings' => $followings,
            'nombrePublications' => $nombrePublications,
        ]);
    }
}

