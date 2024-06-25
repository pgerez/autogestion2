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

    public function findByIdLiquidacion($id, $hospitalid = null)
    {
        if($hospitalid == null):
            return $this->createQueryBuilder('l')
                ->select('sum(ip.cantidad * ip.precio) as suma, h.descriph as hospital')
                //->addselect( '')
                ->addselect( 's.descripcionServicio as servicio')
                ->join('l.cuotas', 'c')
                ->join('c.itemPrefacturacions', 'ip')
                ->join('ip.codserv_FK', 's')
                ->join('ip.Num_Anexo', 'a')
                ->join('a.codH', 'h')
                ->where('l.id = :val')
                ->setParameter('val', $id)
                ->groupBy('a.codH')
                ->groupBy('ip.codserv_FK')
                ->getQuery()
                ->getScalarResult();
        else:
            return $this->createQueryBuilder('l')
                ->select('sum(ip.cantidad * ip.precio) as suma, h.descriph as hospital')
                //->addselect( '')
                ->addselect( 's.descripcionServicio as servicio')
                ->join('l.cuotas', 'c')
                ->join('c.itemPrefacturacions', 'ip')
                ->join('ip.codserv_FK', 's')
                ->join('ip.Num_Anexo', 'a')
                ->join('a.codH', 'h')
                ->where('l.id = :val')
                ->andWhere('h.id = :hosp')
                ->setParameter('val', $id)
                ->setParameter('hosp', $hospitalid)
                ->groupBy('a.codH')
                ->groupBy('ip.codserv_FK')
                ->getQuery()
                ->getScalarResult();
        endif;
    }




}
