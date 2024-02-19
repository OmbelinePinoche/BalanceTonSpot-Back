<?php

namespace App\Repository;

use App\Entity\Location;
use App\Entity\Sport;
use App\Entity\Spot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Spot>
 *
 * @method Spot|null find($id, $lockMode = null, $lockVersion = null)
 * @method Spot|null findOneBy(array $criteria, array $orderBy = null)
 * @method Spot[]    findAll()
 * @method Spot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Spot::class);
    }

    //    /**
    //     * @return Spot[] Returns an array of Spot objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Spot
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    /**
     * Get all the snowboard spots according the a specific location
     *
     * @param Location $location 
     *
     * @return array|null the snow spots for the given location
     */
    public function getSnowSpotsByLocation(Location $location): ?array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.location = :location')
            ->innerJoin('s.sport_id', 'sport')
            ->andWhere('sport.name = :name')
            ->setParameter('location', $location)
            ->setParameter('name', 'Snowboard')
            ->getQuery()
            ->getResult();
    }

    /**
     * Get all the skateboard spots according the a specific location
     *
     * @param Location $location 
     *
     * @return array|null the skateboard spots for the given location
     */
    public function getSkateSpotsByLocation(Location $location): ?array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.location = :location')
            ->innerJoin('s.sport_id', 'sport')
            ->andWhere('sport.name = :name')
            ->setParameter('location', $location)
            ->setParameter('name', 'Skateboard')
            ->getQuery()
            ->getResult();
    }

    /**
     * Get all the spots according the a specific location
     *
     * @param Location $location 
     *
     * @return array|null the spots for the given location
     */
    public function getSpotsByLocation(Location $location): ?array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.location = :location')
            ->setParameter('location', $location)
            ->getQuery()
            ->getResult();
    }


    public function findBySport(Sport $sport)
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.sport_id', 'sport')
            ->where('sport = :sport')
            ->setParameter('sport', $sport)
            ->getQuery()
            ->getResult();
    }

}
