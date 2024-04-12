<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Like;
use App\Entity\Publication;

class LikeController extends AbstractController
{
    #[Route('/like/publication/{id}', name: 'like_publication')]
    public function likePublication(Request $request ,$id, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['error' => 'Utilisateur non connecté'], Response::HTTP_UNAUTHORIZED);
        }

        $publication = $em->getRepository(Publication::class)->find($id);
        if (!$publication) {
            return $this->json(['error' => 'Publication non trouvée'], Response::HTTP_NOT_FOUND);
        }

        // Vérifie si le like existe déjà
        $existingLike = $em->getRepository(Like::class)->findOneBy(['user' => $user, 'publication' => $publication]);
        if ($existingLike) {
            // Logique si vous souhaitez gérer le "unlike", par exemple en supprimant le like existant
            $em->remove($existingLike);
            $em->flush();

            return $this->redirect($request->headers->get('referer'));
        }

        $like = new Like();
        $like->setUser($user);
        $like->setPublication($publication);

        $em->persist($like);
        $em->flush();

        return $this->redirect($request->headers->get('referer'));
    }
}
