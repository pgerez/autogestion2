<?php

namespace App\Repository;

use App\Entity\CertificadoFactura;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CertificadoFactura>
 *
 * @method CertificadoFactura|null find($id, $lockMode = null, $lockVersion = null)
 * @method CertificadoFactura|null findOneBy(array $criteria, array $orderBy = null)
 * @method CertificadoFactura[]    findAll()
 * @method CertificadoFactura[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CertificadoFacturaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CertificadoFactura::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(CertificadoFactura $entity, bool $flush = true): void
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
    public function remove(CertificadoFactura $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return CertificadoFactura[] Returns an array of CertificadoFactura objects
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
    public function findOneBySomeField($value): ?CertificadoFactura
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
