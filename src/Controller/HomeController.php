<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\PublicationRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;
use App\Repository\LikeRepository;

class HomeController extends AbstractController
{
    private Security $security;
    private LikeRepository $likeRepository;

    public function __construct(Security $security, LikeRepository $likeRepository)
    {
        $this->security = $security;
        $this->likeRepository = $likeRepository;
    }

    #[Route('/home', name: 'app_home')]
    public function index(PublicationRepository $publicationRepository): Response
    {
        $publications = $publicationRepository->findBy([], ['DateTime' => 'DESC']);
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

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'publicationsData' => $publicationsData,
        ]);
    }
}
