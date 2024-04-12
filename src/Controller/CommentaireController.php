<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Commentaire;
use App\Entity\Publication;
use Symfony\Bundle\SecurityBundle\Security;


class CommentaireController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/api/commentaire', name: 'api_commentaire_add', methods: ['POST'])]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);
        $user = $this->security->getUser();

        if (!$user) {
            return $this->json(['error' => 'Utilisateur non authentifié'], Response::HTTP_FORBIDDEN);
        }

        $commentaire = new Commentaire();
        $commentaire->setContent($data['content']);
        $commentaire->setDateTime(new \DateTime());

        $publication = $entityManager->getRepository(Publication::class)->find($data['publicationId']);

        if (!$publication) {
            return $this->json(['error' => 'Publication introuvable'], Response::HTTP_NOT_FOUND);
        }

        // Utilisez setUserID au lieu de setUser
        $commentaire->setUserID($user);
        $commentaire->setPostID($publication);

        $entityManager->persist($commentaire);
        $entityManager->flush();

        return $this->json([
            'message' => 'Commentaire ajouté avec succès',
            'content' => $commentaire->getContent(),
        ]);
    }
}
