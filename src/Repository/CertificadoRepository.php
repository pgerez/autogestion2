<?php

namespace App\Repository;

use App\Entity\Certificado;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use mysql_xdevapi\Result;

/**
 * @extends ServiceEntityRepository<Certificado>
 *
 * @method Certificado|null find($id, $lockMode = null, $lockVersion = null)
 * @method Certificado|null findOneBy(array $criteria, array $orderBy = null)
 * @method Certificado[]    findAll()
 * @method Certificado[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CertificadoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Certificado::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Certificado $entity, bool $flush = true): void
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
    public function remove(Certificado $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Certificado[] Returns an array of Certificado objects
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

    /**
     * @return Certificado[] Returns an array of Factura objects
     */

    public function findLastNumero()
    {
        $c = $this->createQueryBuilder('c')
            ->select('c.numero')
            #->andWhere('c.exampleField = :val')
            ->addOrderBy('c.numero', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();

        return $c[0]['numero'] + 1 ;
    }

}
