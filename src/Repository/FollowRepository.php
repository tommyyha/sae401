<?php

namespace App\Repository;

use App\Entity\Follow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Utilisateur;

/**
 * @extends ServiceEntityRepository<Follow>
 *
 * @method Follow|null find($id, $lockMode = null, $lockVersion = null)
 * @method Follow|null findOneBy(array $criteria, array $orderBy = null)
 * @method Follow[]    findAll()
 * @method Follow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FollowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Follow::class);
    }
    
    public function countFollowersOfUser(Utilisateur $user): int
    {
        return $this->createQueryBuilder('f') // 'f' est un alias pour l'entité Follow
            ->select('count(f.id)') // Compte le nombre d'entrées
            ->where('f.UserID = :user') // Condition : UserID correspond à l'utilisateur
            ->setParameter('user', $user) // Associe le paramètre 'user' à l'instance Utilisateur
            ->getQuery() // Prépare la requête
            ->getSingleScalarResult(); // Exécute la requête et retourne un seul résultat scalaire
    }
    
public function countFollowingsOfUser(Utilisateur $user): int
{
    return $this->createQueryBuilder('f')
        ->select('count(f.id)')
        ->where('f.FollowerID = :user')
        ->setParameter('user', $user)
        ->getQuery()
        ->getSingleScalarResult();
}
public function findFollowingsOfUser($userId)
{
    return $this->createQueryBuilder('f')
        ->andWhere('f.FollowerID = :val')
        ->setParameter('val', $userId)
        ->getQuery()
        ->getResult();
}
public function findFollowersOfUser($userId)
{
    return $this->createQueryBuilder('f')
        ->andWhere('f.UserID = :val')
        ->setParameter('val', $userId)
        ->getQuery()
        ->getResult();
}

    //    /**
    //     * @return Follow[] Returns an array of Follow objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Follow
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
