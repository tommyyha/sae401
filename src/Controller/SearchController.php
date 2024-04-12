<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\PublicationRepository;
use App\Repository\UtilisateurRepository;
use App\Repository\LikeRepository;


class SearchController extends AbstractController
{
    private LikeRepository $likeRepository;

    public function __construct( LikeRepository $likeRepository)
    {
        $this->likeRepository = $likeRepository;
    }
    #[Route('/search', name: 'app_search')]
    public function search(Request $request, PublicationRepository $publicationRepo, UtilisateurRepository $userRepo)
    {
        $query = $request->query->get('query');

        if ($query) {
            $publications = $publicationRepo->findByQuery($query);
            $users = $userRepo->findByQuery($query);
        } else {
            $publications = [];
            $users = [];
        }
        $user = $this->getUser();

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

        return $this->render('search/index.html.twig', [
            'publicationsData' => $publicationsData,
            'users' => $users,
            'query' => $query
        ]);
    }
}
