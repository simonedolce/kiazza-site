<?php

namespace App\Repository;

use App\Entity\BannerProfilo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BannerProfilo>
 *
 * @method BannerProfilo|null find($id, $lockMode = null, $lockVersion = null)
 * @method BannerProfilo|null findOneBy(array $criteria, array $orderBy = null)
 * @method BannerProfilo[]    findAll()
 * @method BannerProfilo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BannerProfiloRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BannerProfilo::class);
    }

    public function save(BannerProfilo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(BannerProfilo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return BannerProfilo[] Returns an array of BannerProfilo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BannerProfilo
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
