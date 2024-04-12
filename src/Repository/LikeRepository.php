<?php

namespace App\Repository;

use App\Entity\Like;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Publication;
use App\Entity\Utilisateur;


/**
 * @extends ServiceEntityRepository<Like>
 *
 * @method Like|null find($id, $lockMode = null, $lockVersion = null)
 * @method Like|null findOneBy(array $criteria, array $orderBy = null)
 * @method Like[]    findAll()
 * @method Like[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Like::class);
    }
    public function toggleLike(Publication $publication, UserInterface $user)
    {
        $em = $this->getEntityManager();
        $like = $this->findOneBy(['publication' => $publication, 'user' => $user]);

        if ($like) {
            // Si le like existe, le retirer
            $em->remove($like);
            $em->flush();
            return 'removed';
        } else {
            // Sinon, ajouter un like
            $like = new Like();
            $like->setPublication($publication);
            $like->setUser($user);
            $em->persist($like);
            $em->flush();
            return 'added';
        }
    }
    public function isLikedByUser($publicationId, $user): bool
    {
        return (bool) $this->createQueryBuilder('l')
            ->andWhere('l.publication = :publication')
            ->andWhere('l.user = :user')
            ->setParameter('publication', $publicationId)
            ->setParameter('user', $user)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function countLikesForPublication($publicationId): int
    {
        return (int) $this->createQueryBuilder('l')
            ->select('count(l.id)')
            ->andWhere('l.publication = :publication')
            ->setParameter('publication', $publicationId)
            ->getQuery()
            ->getSingleScalarResult();
    }
    public function findLikersByPublication($publicationId)
    {
        return $this->createQueryBuilder('l')
            ->select('u.Username, u.ProfilePicture')
            ->join('l.user', 'u')
            ->where('l.publication = :publicationId')
            ->setParameter('publicationId', $publicationId)
            ->getQuery()
            ->getResult();
    }
    
//    /**
//     * @return Like[] Returns an array of Like objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Like
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
