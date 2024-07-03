<?php

namespace App\Repository;

use App\Entity\Estimulo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use http\Encoding\Stream\Inflate;

/**
 * @extends ServiceEntityRepository<Estimulo>
 *
 * @method Estimulo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Estimulo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Estimulo[]    findAll()
 * @method Estimulo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EstimuloRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Estimulo::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Estimulo $entity, bool $flush = true): void
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
    public function remove(Estimulo $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Estimulo[] Returns an array of Estimulo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Estimulo
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function updateIdRecibo($array, $idr)
    {
        return $this->createQueryBuilder('e')
            ->update(Estimulo::class, 'e')
            ->set('e.recibo', $idr)
            ->set('e.pagado', 1)
            ->where('e.id IN (:array)')
            ->setParameter('array', $array)
            ->getQuery()
            ->getResult()
            ;
    }
}
