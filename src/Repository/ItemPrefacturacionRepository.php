<?php

namespace App\Repository;

use App\Entity\Anexoii;
use App\Entity\Estado;
use App\Entity\Factura;
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

    /**
     * @return ItemPrefacturacion[] Returns an array of ItemPrefacturacion objects
     */
    public function findItemsByHospAndOS($h,$os,$fi,$ff)
    {
        return $this->createQueryBuilder('i')
            ->join('i.Num_Anexo', 'a')
            ->where('a.codH = :h')
            ->andWhere('a.codOs = :os')
            ->andWhere('a.fechaCarga BETWEEN :fi AND :ff')
            ->andWhere('a.cerrado = 1')
            ->andWhere('i.id_factura_FK is NULL')
            ->setParameter('fi', $fi)
            ->setParameter('ff', $ff)
            ->setParameter('h', $h)
            ->setParameter('os', $os)
            ->orderBy('i.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return ItemPrefacturacion[] Returns an array of ItemPrefacturacion objects
     */
    public function findByFact($hospitalId)
    {
        return $this->createQueryBuilder('i')
            ->select('os.rowId as id, os.denomina as denomina, os.codobra as codobra')
            ->join('i.Num_Anexo', 'a')
            ->join('a.codOs', 'os')
            ->where('a.codH = :h')
            ->andWhere('i.id_factura_FK is NULL')
            ->setParameter('h', $hospitalId)
            ->groupBy('os.codobra')
            ->orderBy('os.codobra', 'ASC')
            ->getQuery()
            ->getScalarResult()
            ;
    }

    /**
     * @return ItemPrefacturacion[] Returns an array of ItemPrefacturacion objects
     */
    public function findTotalItems($array)
    {
        return $this->createQueryBuilder('i')
            ->select('sum(i.cantidad * i.precio)')
            ->where('i.id IN (:array)')
            ->setParameter('array', $array)
            ->orderBy('i.id', 'ASC')
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    /**
     * @return ItemPrefacturacion[] Returns an array of ItemPrefacturacion objects
     */
    public function updateIdfacturaItems($array, $idf)
    {
        return $this->createQueryBuilder('i')
            ->update(ItemPrefacturacion::class, 'i')
            ->set('i.id_factura_FK', $idf)
            ->where('i.id IN (:array)')
            ->setParameter('array', $array)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     *
     */
    public function updateCheckItems($array, $idc, $idF)
    {
        $debitoT = null;
        $em = $this->getEntityManager();
        $debParcial = $this->_em->getRepository(Estado::class)->find(['id' => 5]);
        $percibida  = $this->_em->getRepository(Estado::class)->find(['id' => 3]);
        foreach ($array as $id => $value):
            $this->createQueryBuilder('i')
                ->update(ItemPrefacturacion::class, 'i')
                ->set('i.estadoPago', 1)
                ->set('i.cuota', $idc)
                ->set('i.montoPago', $value)
                ->where('i.id = (:id)')
                ->setParameter('id', $id)
                ->getQuery()
                ->getResult();
            $debitoT = $debitoT + $value;
        endforeach;

        if($debitoT == 0):
            $factura = $this->_em->getRepository(Factura::class)->find(['idFactura' => $idF]);
            $factura->setEstadoId($percibida);
            $factura->setDebito($debitoT);
        else:
            $factura = $this->_em->getRepository(Factura::class)->find(['idFactura' => $idF]);
            $factura->setEstadoId($debParcial);
            $factura->setDebito($debitoT);
        endif;
        $em->persist($factura);
        $em->flush();
        return true;
    }

    /**
     * @return ItemPrefacturacion[] Returns an array of ItemPrefacturacion objects
     */
    public function updateUncheckItems($idf, $idc, $idF)
    {
        $em = $this->getEntityManager();
        $percibida  = $this->_em->getRepository(Estado::class)->find(['id' => 3]);
        $factura = $this->_em->getRepository(Factura::class)->find(['idFactura' => $idF]);
        $factura->setEstadoId($percibida);
        $factura->setDebito(0);
        $em->persist($factura);
        $em->flush();

        return $this->createQueryBuilder('i')
            ->update(ItemPrefacturacion::class, 'i')
            ->set('i.estadoPago', 0)
            ->set('i.montoPago', 0)
            ->set('i.cuota', 0)
            ->where('i.id_factura_FK = (:idf)')
            ->andwhere('i.cuota = (:idc)')
            ->setParameter('idc', $idc)
            ->setParameter('idf', $idf)
            ->getQuery()
            ->getResult()
        ;
    }


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
