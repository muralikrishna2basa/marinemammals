<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class SpecimensRepository extends EntityRepository
{
    public function findBySeqno(\AppBundle\Entity\EventStates $scnSeqno)
    {
        $qb = $this->createQueryBuilder('s')
            ->select('s')
            ->where('s.scnSeqno = :scnSeqno')
        ->setParameter('scnSeqno',$scnSeqno);
        return $qb->getQuery()
            ->getResult();
    }
}

