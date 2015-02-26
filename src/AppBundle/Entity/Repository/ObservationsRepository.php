<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query;

class ObservationsRepository extends EntityRepository
{
    public function getCompleteObservation()
    {
        $q=$this->getCompleteObservationQb()->getQuery();
        $sql=$q->getSQL();
        return $q->getResult(Query::HYDRATE_OBJECT); //unfortunately, hydrate object is needed to make use of the bidirectional asociations!
    }

    public function getCompleteObservationQb()
    {
        return $this->createQueryBuilder('o')
            ->select('partial o.{eseSeqno,latDec, lonDec}, partial st.{seqno,code,areaType}, partial e.{seqno,eventDatetime}, partial s2e.{eseSeqno,scnSeqno}, partial s.{seqno,scnNumber}, partial t.{seqno,canonicalName,vernacularNameEn}')
            ->leftJoin('o.stnSeqno', 'st')
            ->leftJoin('st.pceSeqno', 'p')
            ->innerJoin('o.eseSeqno', 'e')
            ->innerJoin('AppBundle\Entity\Spec2Events', 's2e', Expr\Join::WITH, 's2e.eseSeqno = e.seqno')
            ->leftJoin('s2e.scnSeqno', 's')
            ->leftJoin('s.txnSeqno', 't');
    }
}
