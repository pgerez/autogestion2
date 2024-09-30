<?php

namespace App\Repository;

use App\Entity\Cuota;
use App\Entity\Hospital;
use App\Entity\Liquidacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cuota>
 *
 * @method Cuota|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cuota|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cuota[]    findAll()
 * @method Cuota[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CuotaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cuota::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Cuota $entity, bool $flush = true): void
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
    public function remove(Cuota $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return int cantidad de cuotas afectadas
     */
    public function updateByFechaLiquidacion($fd,$fh,$idl,$h)
    {
        $em = $this->getEntityManager(); // Get the Entity Manager
        $liquidacion = $this->_em->getRepository(Liquidacion::class)->find(['id' => $idl]);
        if($h == null):
            $hpgd = $this->_em->getRepository(Hospital::class)->arrayHpgd();
            // Fetch Cuotas meeting the criteria
            #$cuotas =
            $qb = $this->_em->createQueryBuilder();
            $cuotas = $this->createQueryBuilder('c')
                ->join('c.pago', 'p')
                ->where('c.fechaLiquidacion BETWEEN (:startDate) AND (:endDate)')
                ->andWhere('p.hospitalId not in (:hpgd) OR p.hospitalId is null')
                ->andWhere('c.liquidacion is null')
                ->setParameters([
                    'startDate'  => $fd,
                    'endDate'    => $fh,
                    'hpgd'       => $hpgd,
                ])
                ->getQuery()
                ->getResult();
            $updatedCount = 0;
            foreach ($cuotas as $cuota) {
                $cuota->setLiquidacion($liquidacion); // Assuming setter exists
                $em->persist($cuota);
                $updatedCount++;
            }

            $em->flush(); // Perform the updates in a single flush
            return $updatedCount;
        else:

            // Fetch Cuotas meeting the criteria
            $cuotas = $this->createQueryBuilder('c')
                ->join('c.pago', 'p')
                ->where('c.fechaLiquidacion BETWEEN (:startDate) AND (:endDate)')
                ->andWhere('c.liquidacion is null')
                ->andWhere('p.hospitalId = (:hospitalId)')
                ->setParameters([
                    'startDate' => $fd,
                    'endDate' => $fh,
                    'hospitalId' => $h,
                ])
                ->getQuery()
                ->getResult();
            $updatedCount = 0;
            foreach ($cuotas as $cuota) {
                $cuota->setLiquidacion($liquidacion); // Assuming setter exists
                $em->persist($cuota);
                $updatedCount++;
            }

            $em->flush(); // Perform the updates in a single flush
            return $updatedCount;
        endif;
    }

    // /**
    //  * @return Cuota[] Returns an array of Cuota objects
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
    public function findOneBySomeField($value): ?Cuota
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
