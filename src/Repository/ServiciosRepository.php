<?php

namespace App\Repository;

use App\Entity\Servicios;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Servicios>
 *
 * @method Servicios|null find($id, $lockMode = null, $lockVersion = null)
 * @method Servicios|null findOneBy(array $criteria, array $orderBy = null)
 * @method Servicios[]    findAll()
 * @method Servicios[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiciosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Servicios::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Servicios $entity, bool $flush = true): void
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
    public function remove(Servicios $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Servicios[] Returns an array of Servicios objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    
    public function findOneByCodserv($codserv): ?Servicios
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.codserv = :val')
            ->setParameter('val', $codserv)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
}
