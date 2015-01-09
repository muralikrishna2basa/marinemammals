<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class StationsRepository extends EntityRepository
{
    public function getAllStations()
    {
        $qb = $this->createQueryBuilder('s')
            ->select('s')
            ->addOrderBy('s.areaType', 'ASC')
            ->addOrderBy('s.code', 'ASC');

        return $qb->getQuery()
            ->getResult();
    }

    public function getAllStationsPlaceQb(){
        $qb = $this->createQueryBuilder('s')
            ->select('s')
            ->addSelect('p')
            ->leftJoin('s.pceSeqno','p')
            ->addOrderBy('s.areaType', 'ASC')
            ->addOrderBy('p.name', 'ASC');
        return $qb;
    }
}
