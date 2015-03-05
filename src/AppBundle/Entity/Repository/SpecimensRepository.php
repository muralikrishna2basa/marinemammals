<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class SpecimensRepository extends EntityRepository
{
    public function findBySeqno($seqno)
    {
        $qb = $this->createQueryBuilder('s')
            ->select('s')
            ->addSelect('t')
            ->leftJoin('s.txnSeqno','t')
            ->where('s.seqno = :seqno')
        ->setParameter('seqno',$seqno);
        $res=$qb->getQuery()
            ->getSingleResult(Query::HYDRATE_OBJECT);
        return $res;
    }

}

