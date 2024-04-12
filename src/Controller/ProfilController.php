<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UtilisateurRepository;
use App\Repository\PublicationRepository;
use App\Entity\Utilisateur;
use App\Entity\Publication;
use App\Repository\FollowRepository;
use App\Entity\Follow;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\LikeRepository;






class ProfilController extends AbstractController
{
    public function __construct( LikeRepository $likeRepository)
    {
        $this->likeRepository = $likeRepository;
    }
    #[Route('/profil/{username}', name: 'app_profil')]
    public function index(string $username, UtilisateurRepository $userRepository, PublicationRepository $publicationRepository, FollowRepository $followRepository): Response
    {
    $user = $userRepository->findOneBy(['Username' => $username]);
    $currentUser = $this->getUser(); // Obtient l'utilisateur actuellement connecté
    $followersCount = $followRepository->countFollowersOfUser($user);
    $followingsCount = $followRepository->countFollowingsOfUser($user); // Compte le nombre d'abonnements
    $followers = $followRepository->findFollowersOfUser($user);
    $followings = $followRepository->findFollowingsOfUser($user);


    if (!$user) {
        throw $this->createNotFoundException('L\'utilisateur demandé n\'existe pas.');
    }

    $publications = $publicationRepository->findBy(['UserID' => $user->getId()]);
    $publicationsData = [];

        foreach ($publications as $publication) {
            $publicationId = $publication->getId();
            $isLikedByCurrentUser = $this->likeRepository->isLikedByUser($publicationId, $user);
            $likesCount = $this->likeRepository->countLikesForPublication($publicationId);
            $likers = $this->likeRepository->findLikersByPublication($publicationId); // Assurez-vous d'implémenter cette méthode

            $filename = $publication->getPostContent();
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            $fileType = 'unknown';
            if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif'])) {
                $fileType = 'image';
            } elseif (in_array(strtolower($extension), ['mp4', 'avi', 'mov'])) {
                $fileType = 'video';
            }

            $publicationsData[] = [
                'publication' => $publication,
                'isLikedByCurrentUser' => $isLikedByCurrentUser,
                'likesCount' => $likesCount,
                'fileType' => $fileType,
                'likers' => $likers, // Liste des utilisateurs qui ont liké
            ];
        }
    // Assurez-vous que l'utilisateur est connecté avant de vérifier s'il suit l'utilisateur du profil
    $isFollowedByCurrentUser = false;
    if ($currentUser) {
        $follow = $followRepository->findOneBy([
            'UserID' => $user,
            'FollowerID' => $currentUser,
            
        ]);
        $isFollowedByCurrentUser = null !== $follow;
    }
    $nombrePublications = $publicationRepository->countPublicationsByUser($currentUser->getId());

    return $this->render('profil/index.html.twig', [
        'user' => $user,
        'publicationsData' => $publicationsData,
        'isFollowedByCurrentUser' => $isFollowedByCurrentUser,
        'followersCount' => $followersCount,
        'followingsCount' => $followingsCount, // Passe le nombre d'abonnements à la vue
        'followers' => $followers,
        'followings' => $followings,
        'nombrePublications' => $nombrePublications,


    ]);
    }
    #[Route('/follow/{username}', name: 'follow_route', methods: ['POST'])]
    public function follow(string $username, UtilisateurRepository $userRepository, FollowRepository $followRepository, EntityManagerInterface $em): Response
    {
        $targetUser = $userRepository->findOneBy(['Username' => $username]);
        $currentUser = $this->getUser(); // Assurez-vous que votre système d'authentification est bien configuré
    
        if (!$targetUser) {
            $this->addFlash('error', 'Utilisateur non trouvé');
            return $this->redirectToRoute('default_route'); // Remplacez 'default_route' par la route par défaut ou une autre route appropriée
        }
    
        if ($followRepository->findOneBy(['UserID' => $targetUser, 'FollowerID' => $currentUser])) {
            // L'utilisateur suit déjà le cible
            $this->addFlash('info', 'Vous suivez déjà cet utilisateur.');
            return $this->redirectToRoute('app_profil', ['username' => $username]);
        }
    
        $follow = new Follow();
        $follow->setUserID($targetUser);
        $follow->setFollowerID($currentUser);
    
        $em->persist($follow);
        $em->flush();
    
        $this->addFlash('success', 'Suivi avec succès.');
        return $this->redirectToRoute('app_profil', ['username' => $username]);
    }
    
    #[Route('/unfollow/{username}', name: 'unfollow_route', methods: ['POST'])]
    public function unfollow(string $username, UtilisateurRepository $userRepository, FollowRepository $followRepository, EntityManagerInterface $em): Response
    {
        $targetUser = $userRepository->findOneBy(['Username' => $username]);
        $currentUser = $this->getUser();
    
        if (!$targetUser) {
            $this->addFlash('error', 'Utilisateur non trouvé');
            return $this->redirectToRoute('default_route'); // Remplacez 'default_route' par la route par défaut ou une autre route appropriée
        }
    
        $follow = $followRepository->findOneBy(['UserID' => $targetUser, 'FollowerID' => $currentUser]);
    
        if (!$follow) {
            // L'utilisateur ne suit pas le cible
            $this->addFlash('info', 'Vous ne suivez pas cet utilisateur.');
            return $this->redirectToRoute('app_profil', ['username' => $username]);
        }
    
        $em->remove($follow);
        $em->flush();
    
        $this->addFlash('success', 'Vous ne suivez plus cet utilisateur.');
        return $this->redirectToRoute('app_profil', ['username' => $username]);
    }
    
     

}