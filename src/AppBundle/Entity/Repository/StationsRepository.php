<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class StationsRepository extends EntityRepository
{
    public function getAll()
    {
        return $this->getAllStationsPlaceQb()->getQuery()
            ->getResult();
    }

    public function getAllStationsPlaceQb()
    {
        $qb = $this->createQueryBuilder('s')
            ->select('s')
            ->addSelect('p')
            ->leftJoin('s.pceSeqno', 'p')
            ->addOrderBy('s.areaType', 'ASC')
            ->addOrderBy('s.description', 'ASC')
            ->addOrderBy('p.name', 'ASC');
        return $qb;
    }

    public function getAllStationsBelongingToPlacesQb($places)
    {
        $qb = $this->getAllStationsPlaceQb();
        return $qb->andWhere('s.pceSeqno IN (:places)')
            ->setParameter('places', $places);
    }

    public function getAllStationsBelongingToPlaceQb(\AppBundle\Entity\Places $place)
    {
        $qb = $this->getAllStationsPlaceQb();
        return $qb->andWhere('s.pceSeqno = :place')
            ->setParameter('place', $place);
    }

    public function getAllStationsBelongingToPlaceDeepQb(\AppBundle\Entity\Places $place)
    {
        $childPlaces = $place->getPlaces();
        $childPlaces->add($place);
        return $this->getAllStationsBelongingToPlacesQb($childPlaces->toArray());
    }

    public function getAllStationsTypes()
    {
        $qb = $this->createQueryBuilder('s')
            ->select('s.areaType')
            ->distinct()
            ->addOrderBy('s.areaType', 'ASC');

        return $qb->getQuery()
            ->getResult();
    }
}
