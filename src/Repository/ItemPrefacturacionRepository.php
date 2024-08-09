<?php

namespace App\Repository;

use App\Entity\Anexoii;
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
    public function updateCheckItems($array, $idc)
    {
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
        endforeach;

        return true;
    }

    /**
     * @return ItemPrefacturacion[] Returns an array of ItemPrefacturacion objects
     */
    public function updateUncheckItems($idf, $idc)
    {
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
