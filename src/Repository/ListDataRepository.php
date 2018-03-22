<?php

namespace App\Repository;

use App\Entity\ListData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ListData|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListData|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListData[]    findAll()
 * @method ListData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListDataRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ListData::class);
    }

//    /**
//     * @return ListData[] Returns an array of ListData objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

/*
    public function getUsersData($uid): ?ListData
    {
        $query = $this->createQueryBuilder('d')
            ->andWhere('d.uid = :val')
            ->setParameter('val', $uid)
            ->getQuery()
            ->getOneOrNullResult();

        return $query->execute();
    }
*/
}
