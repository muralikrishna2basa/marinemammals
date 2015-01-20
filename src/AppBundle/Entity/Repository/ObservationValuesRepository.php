<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class ObservationValuesRepository extends EntityRepository
{
    public function getObservationValuesPm()
    {
        $qb = $this->createQueryBuilder('ov')
            ->select('ov')
            ->addSelect('pm')
            ->leftJoin('pmdSeqno','pm')
            ->addOrderBy('pm.name', 'ASC');

        return $qb->getQuery()
            ->getResult();
    }
}
