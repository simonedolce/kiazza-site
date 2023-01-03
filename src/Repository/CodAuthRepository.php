<?php

namespace App\Repository;

use App\Entity\CodAuth;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CodAuth>
 *
 * @method CodAuth|null find($id, $lockMode = null, $lockVersion = null)
 * @method CodAuth|null findOneBy(array $criteria, array $orderBy = null)
 * @method CodAuth[]    findAll()
 * @method CodAuth[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CodAuthRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CodAuth::class);
    }

    public function save(CodAuth $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CodAuth $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CodAuth[] Returns an array of CodAuth objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    public function findOneByCodice($codice): ?CodAuth
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.codice = :val')
            ->setParameter('val', $codice)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
