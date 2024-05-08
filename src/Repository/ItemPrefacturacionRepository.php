<?php

namespace App\Repository;

use App\Entity\ItemPrefacturacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ItemPrefacturacion>
 *
 * @method ItemPrefacturacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method ItemPrefacturacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method ItemPrefacturacion[]    findAll()
 * @method ItemPrefacturacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemPrefacturacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ItemPrefacturacion::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(ItemPrefacturacion $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(ItemPrefacturacion $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return ItemPrefacturacion[] Returns an array of ItemPrefacturacion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ItemPrefacturacion
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
