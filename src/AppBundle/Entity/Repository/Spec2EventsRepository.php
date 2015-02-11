<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class Spec2EventsRepository extends EntityRepository
{
    public function findByEseSeqno(\AppBundle\Entity\EventStates $eseSeqno)
    {
        $qb = $this->createQueryBuilder('s2e')
            ->select('s2e')
            ->where('s2e.eseSeqno = :eseSeqno')
        ->setParameter('eseSeqno',$eseSeqno);
        return $qb->getQuery()
            ->getResult();
    }
}

