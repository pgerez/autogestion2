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

    public function findByAdeudadas($hospitalid=null,$osid=null,$fechai=null,$fechaf=null)
    {
        $adeudadas = $this->createQueryBuilder('f')
            ->select('f.digitalNum as numero','f.digitalPv as pv')
            ->join('f.codOs','os')
            ->join('f.hospitalId', 'h')
            ->where('f.estadoId = 1');
        if($fechai!=null):
            $adeudadas->andWhere("f.fechaEmision >= '".$fechai."'");
        endif;
        if($fechaf!=null):
            $adeudadas->andWhere("f.fechaEmision <= '".$fechaf."'");
        endif;
        if($osid!=null):
            $adeudadas->andWhere('f.codOs = '.$osid);
        endif;
        if($hospitalid!=null):
            $adeudadas->andWhere('f.hospitalId = '.$hospitalid);
        endif;
            $adeudadas->orderBy('f.hospitalId','ASC')
                ->getQuery()
                ->getResult();

        return $adeudadas;

    }

}
