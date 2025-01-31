<?php

namespace App\Repository;

use App\Entity\Cuota;
use App\Entity\Liquidacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Liquidacion>
 *
 * @method Liquidacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Liquidacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Liquidacion[]    findAll()
 * @method Liquidacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LiquidacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Liquidacion::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Liquidacion $entity, bool $flush = true): void
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
    public function remove(Liquidacion $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Liquidacion[] Returns an array of Liquidacion objects
     */

    public function findByIdLiquidacionByEstimulo($id)
    {
        return $this->createQueryBuilder('l')
            ->select('sum((ip.cantidad * ip.precio) - ip.montoPago) as suma, h.id as hospital')
            ->join('l.cuotas', 'c')
            ->join('c.itemPrefacturacions', 'ip')
            ->join('ip.codserv_FK', 's')
            ->join('ip.Num_Anexo', 'a')
            ->join('a.codH', 'h')
            ->where('l.id = :val')
            ->setParameter('val', $id)
            ->groupBy('a.codH')
            ->getQuery()
            ->getScalarResult();
    }

     /**
      * @return Liquidacion[] Returns an array of Liquidacion objects
      */

    public function findByIdLiquidacion($id, $hospitalid = null)
    {
        if($hospitalid == null):
            return $this->createQueryBuilder('l')
                ->select('sum(ip.cantidad * ip.precio) as suma, sum(ip.montoPago) as deb, o.denomina as os, h.descriph as hospital, h.id as id, s.descripcionServicio as servicio, f.digitalPv as pv, f.digitalNum as num')
                ->join('l.cuotas', 'c')
                ->join('c.itemPrefacturacions', 'ip')
                ->join('ip.codserv_FK', 's')
                ->join('ip.id_factura_FK', 'f')
                ->join('ip.Num_Anexo', 'a')
                ->join('a.codOs', 'o')
                ->join('a.codH', 'h')
                ->where('l.id = :val')
                ->setParameter('val', $id)
                ->groupBy('h.id','o.rowId','f.idFactura','s.codserv')
                ->getQuery()
                ->getScalarResult();
        else:
            return $this->createQueryBuilder('l')
                ->select('sum(ip.cantidad * ip.precio) as suma, sum(ip.montoPago) as deb, o.denomina as os, h.descriph as hospital, h.id as id, s.descripcionServicio as servicio, f.digitalPv as pv, f.digitalNum as num')
                ->join('l.cuotas', 'c')
                ->join('c.itemPrefacturacions', 'ip')
                ->join('ip.codserv_FK', 's')
                ->join('ip.id_factura_FK', 'f')
                ->join('ip.Num_Anexo', 'a')
                ->join('a.codOs', 'o')
                ->join('a.codH', 'h')
                ->where('l.id = :val')
                ->andWhere('h.id = :hosp')
                ->setParameter('val', $id)
                ->setParameter('hosp', $hospitalid)
                ->groupBy('h.id','o.rowId','f.idFactura','s.codserv')
                ->getQuery()
                ->getScalarResult();
        endif;
    }

    public function findByIdLiquidacionOnlyOs($id, $hospitalid = null)
    {
        if($hospitalid == null):
            return $this->createQueryBuilder('l')
                ->select('sum(ip.cantidad * ip.precio) as suma, sum(ip.montoPago) as deb, o.denomina as os')
                ->join('l.cuotas', 'c')
                ->join('c.itemPrefacturacions', 'ip')
                ->join('ip.codserv_FK', 's')
                ->join('ip.id_factura_FK', 'f')
                ->join('ip.Num_Anexo', 'a')
                ->join('a.codOs', 'o')
                ->join('a.codH', 'h')
                ->where('l.id = :val')
                ->setParameter('val', $id)
                ->groupBy('o.rowId')
                ->getQuery()
                ->getScalarResult();
        else:
            return $this->createQueryBuilder('l')
                ->select('sum(ip.cantidad * ip.precio) as suma, sum(ip.montoPago) as deb, o.denomina as os')
                ->join('l.cuotas', 'c')
                ->join('c.itemPrefacturacions', 'ip')
                ->join('ip.codserv_FK', 's')
                ->join('ip.id_factura_FK', 'f')
                ->join('ip.Num_Anexo', 'a')
                ->join('a.codOs', 'o')
                ->join('a.codH', 'h')
                ->where('l.id = :val')
                ->andWhere('h.id = :hosp')
                ->setParameter('val', $id)
                ->setParameter('hosp', $hospitalid)
                ->groupBy('o.rowId')
                ->getQuery()
                ->getScalarResult();
        endif;
    }




}
