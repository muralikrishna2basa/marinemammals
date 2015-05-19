<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class SamplesRepository extends EntityRepository
{

    public function getCompleteSamples()
    {
        return $this->getCompleteSamplesQb()->getQuery()
            ->getResult();
    }

    public function getCompleteSamplesQb()
    {
        return $this->buildSampleQuery()->select('s,oln,lte,ogn,ncy,ese,s2e,scn,txn');
    }

    public function getFastSamples()
    {
        return $this->getFastSamplesQb()->getQuery()
            ->getScalarResult();
    }

    public function getFastSamplesQb()
    {

        return $this->buildSampleQuery()->select('partial s.{seqno,conservationMode, analyzeDest,speType}, partial oln.{seqno}, partial lte.{seqno}, partial ogn.{code,name}, partial ncy.{eseSeqno}, partial ese.{seqno,eventDatetime}, partial s2e.{eseSeqno,scnSeqno}, partial scn.{seqno}, partial txn.{seqno,canonicalName,vernacularNameEn}')
            ->addSelect('(SELECT MAX(ese2.eventDatetime) AS event_datetime
            FROM AppBundle:EventStates ese2
            JOIN ese2.observation o
            JOIN ese2.spec2events s2e2
            WHERE ese.seqno = ese2.seqno GROUP BY s2e2.scnSeqno) as date_found'
            );
    }

    private function buildSampleQuery()
    {
        return $this->createQueryBuilder('s')
            ->leftJoin('s.olnLteSeqno', 'oln')
            ->leftJoin('oln.lteSeqno', 'lte')
            ->leftJoin('lte.ognCode', 'ogn')
            ->leftJoin('oln.ncyEseSeqno', 'ncy')
            ->leftJoin('ncy.eseSeqno', 'ese')
            ->leftJoin('ese.spec2events', 's2e')
            ->leftJoin('s2e.scnSeqno', 'scn')
            ->leftJoin('scn.txnSeqno', 'txn');
    }
}
