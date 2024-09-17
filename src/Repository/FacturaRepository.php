<?php

namespace App\Repository;

use App\Entity\Factura;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Factura>
 *
 * @method Factura|null find($id, $lockMode = null, $lockVersion = null)
 * @method Factura|null findOneBy(array $criteria, array $orderBy = null)
 * @method Factura[]    findAll()
 * @method Factura[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FacturaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Factura::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Factura $entity, bool $flush = true): void
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
    public function remove(Factura $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

     /**
      * @return Factura[] Returns an array of Factura objects
      */
    
    public function findById($ptovta)
    {
        return $this->createQueryBuilder('f')
            ->select('f.numeroFactura')
            ->andWhere('f.puntoVenta = :val')
            ->setParameter('val', $ptovta)
            ->orderBy('f.idFactura', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return [] Returns an array of Anexo items objects
     */
    public function findAnexoItems($id)
    {
        return $this->createQueryBuilder('f')
            ->select('a.numAnexo','a.documento','a.apeynom','i.cantidad','i.precio','s.descripcionServicio')
            ->join('f.itemPrefacturacions', 'i')
            ->join('i.Num_Anexo', 'a')
            ->join('i.codserv_FK', 's')
            ->andWhere('f.idFactura = :val')
            ->setParameter('val', $id)
            ->orderBy('i.Num_Anexo', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

}
