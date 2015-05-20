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

    public function getPartialSamples()
    {
        return $this->getPartialSamplesQb()->getQuery()
            ->getScalarResult();
    }

    public function getPartialSamplesQb()
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

    public function getSamplesListWithPagination($order_by = array(), $offset = 0, $limit = 0, $scalar=true)
    {
        //Create query builder for languages table
        $qb = $this->getPartialSamplesQb();

        //Show all if offset and limit not set, also show all when limit is 0
        if ((isset($offset)) && (isset($limit))) {
            if ($limit > 0) {
                $qb->setFirstResult($offset);
                $qb->setMaxResults($limit);
            }
            //else we want to display all items on one page
        }
        //Adding defined sorting parameters from variable into query
        foreach ($order_by as $key => $value) {
            $qb->add('orderBy', 's.' . $key . ' ' . $value);
        }
        //Get our query
        $q = $qb->getQuery();
        //Return result
        if($scalar){
            return $q->getScalarResult();
        }
        else{
            return $q->getResult();
        }

    }

    public function getSamplesCount()
    {
        //Create query builder for languages table
        $qb = $this->createQueryBuilder('s');
        //Add Count expression to query
        $qb->add('select', $qb->expr()->count('s'));
        //Get our query
        $q = $qb->getQuery();
        //Return number of items
        return $q->getSingleScalarResult();
    }
}
