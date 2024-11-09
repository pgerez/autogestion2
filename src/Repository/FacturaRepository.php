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
     * @return Factura[] Returns an array items objects
     */
    public function findAnexoItems($id)
    {
        return $this->createQueryBuilder('f')
            ->select('a.numAnexo','a.documento','a.apeynom','i.cantidad','i.precio','n.tema','s.descripcionServicio as servicio')
            ->join('f.itemPrefacturacions', 'i')
            ->join('i.Num_Anexo', 'a')
            ->join('i.nomencla', 'n')
            ->join('i.codserv_FK', 's')
            ->andWhere('f.idFactura = :val')
            ->setParameter('val', $id)
            ->orderBy('i.Num_Anexo', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAdeudadas($hospitalid=null,$osid=null,$fechai=null,$fechaf=null)
    {
        if($osid != null):
            $adeudadas = $this->createQueryBuilder('f')
                #->select('f.digitalNum as numero','f.digitalPv as pv','f.montoFact as monto','f.fechaEmision as fechaEmision')
                ->innerJoin('f.codOs','os')
                ->innerJoin('f.hospitalId', 'h')
                ->where('f.estadoId = 1')
                ->andWhere('f.fechaEmision BETWEEN (:fechai) AND (:fechaf)')
                ->andWhere('f.codOs = (:osid)')
                ->andWhere('f.hospitalId = (:hospitalid)')
                ->setParameters(['fechaf' => $fechaf, 'fechai' => $fechai])
                ->setParameter('osid' , $osid)
                ->setParameter('hospitalid', $hospitalid)
                ->orderBy('f.hospitalId','ASC')
                ->addorderBy('f.codOs','ASC')
                ->getQuery()
                ->getResult();
        else:
            $adeudadas = $this->createQueryBuilder('f')
                #->select('f.digitalNum as numero','f.digitalPv as pv','f.montoFact as monto','f.fechaEmision as fechaEmision')
                ->innerJoin('f.hospitalId', 'h')
                ->where('f.estadoId = 1')
                ->andWhere('f.fechaEmision BETWEEN (:fechai) AND (:fechaf)')
                ->andWhere('f.hospitalId = (:hospitalid)')
                ->setParameters(['fechaf' => $fechaf, 'fechai' => $fechai])
                ->setParameter('hospitalid', $hospitalid)
                ->orderBy('f.hospitalId','ASC')
                ->addorderBy('f.codOs','ASC')
                ->getQuery()
                ->getResult();
        endif;


        return $adeudadas;

    }

}
