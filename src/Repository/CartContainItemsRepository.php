<?php

namespace App\Repository;

use App\Entity\CartContainItems;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CartContainItems|null find($id, $lockMode = null, $lockVersion = null)
 * @method CartContainItems|null findOneBy(array $criteria, array $orderBy = null)
 * @method CartContainItems[]    findAll()
 * @method CartContainItems[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartContainItemsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CartContainItems::class);
    }

    // /**
    //  * @return CartContainItems[] Returns an array of CartContainItems objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CartContainItems
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
