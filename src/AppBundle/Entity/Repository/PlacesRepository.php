<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class PlacesRepository extends EntityRepository
{
    public function getAllPlaces()
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p')
            ->addOrderBy('p.pceSeqno', 'ASC')
            ->addOrderBy('p.name', 'ASC');
        return $qb->getQuery()
            ->getResult();
    }

    public function getAllPlacesParentQb()
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p')
            ->addSelect('p2')
            ->leftJoin('p.pceSeqno', 'p2')
            ->addOrderBy('p2.name', 'ASC')
            ->addOrderBy('p.name', 'ASC');
        return $qb;
    }

    public function getAllCountries()
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p')
            ->addOrderBy('p.name', 'ASC')
            ->where("p.type = 'CTY'");
        return $qb->getQuery()
            ->getResult();
    }
}
