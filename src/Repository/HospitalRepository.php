<?php

namespace App\Repository;

use App\Entity\Hospital;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Hospital>
 *
 * @method Hospital|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hospital|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hospital[]    findAll()
 * @method Hospital[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HospitalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hospital::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Hospital $entity, bool $flush = true): void
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
    public function remove(Hospital $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
    * @return Hospital[] Returns an array of Hospital objects
    */
    
    public function findById()
    {
        return $this->createQueryBuilder('h')
            #->andWhere('h.exampleField = :val')
            #->setParameter('val', $value)
            ->orderBy('h.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Hospital[] Returns an array of Hospital objects
     */

    public function findByNotHpgd($id)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.id = :val')
            ->setParameter('val', $id)
            ->orderBy('h.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByCodigoh($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.codigoh = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function arrayHpgd()
    {
        return $this->createQueryBuilder('h')
            ->select('h.id as id')
            ->andWhere('h.hpgd = 1')
            ->getQuery()
            ->getArrayResult()
            ;
    }

    public function findAllNotHpgd()
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.hpgd = 0')
            ->getQuery()
            ->getArrayResult()
            ;
    }

    public function findByHpgd($value)
    {
        return $this->createQueryBuilder('h')
            ->where('h.id = :id')
            ->andWhere('h.hpgd = 1')
            ->setParameter('id', $value)
            ->getQuery()
            ->getArrayResult()
            ;
    }


}
