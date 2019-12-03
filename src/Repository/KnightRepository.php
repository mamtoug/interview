<?php

namespace App\Repository;

use App\Entity\Knight;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Knight|null find($id, $lockMode = null, $lockVersion = null)
 * @method Knight|null findOneBy(array $criteria, array $orderBy = null)
 * @method Knight[]    findAll()
 * @method Knight[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KnightRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Knight::class);
    }

    public function allKnight($limit, $offset)
    {
        $qb = $this->createQueryBuilder('k')
            ->select('k.id as id , k.name as name, k.strength as strength , k.weaponPower as weaponPower');
        if ($limit && $offset) {
            $qb->setMaxResults($limit)
                ->setFirstResult($offset);
        }
        return $qb->getQuery()->getArrayResult();
    }


    public function oneKnight($id)
    {
        $qb = $this->createQueryBuilder('k')
            ->select('k.id as id , k.name as name, k.strength as strength , k.weaponPower as weaponPower')
            ->where('k.id = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()->getOneOrNullResult();
    }


}
