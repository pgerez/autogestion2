<?php

namespace App\Repository;

use App\Entity\ObrasSociales;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ObrasSociales>
 *
 * @method ObrasSociales|null find($id, $lockMode = null, $lockVersion = null)
 * @method ObrasSociales|null findOneBy(array $criteria, array $orderBy = null)
 * @method ObrasSociales[]    findAll()
 * @method ObrasSociales[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObrasSocialesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ObrasSociales::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(ObrasSociales $entity, bool $flush = true): void
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
    public function remove(ObrasSociales $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

     /**
      * @return ObrasSociales[] Returns an array of ObrasSociales objects
      */

    public function findByRnos($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.codobra = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?ObrasSociales
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
