<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query;

class ObservationsRepository extends EntityRepository
{

    public function removeDoubles($res)
    {
        foreach ($res as $i => $r) {
            if (get_class($r) === 'AppBundle\Entity\Spec2Events') {
                unset($res[$i]);
            }
        }
        return $res;
    }

    public function getCompleteObservations()
    {
        $res = $this->getCompleteObservationsQb()->getQuery()->getResult(Query::HYDRATE_OBJECT);
        return ($res);

    }

    public function getCompleteObservationsExcludeConfidential()
    {
        $res = $this->getCompleteObservationsQb()->getQuery()->getResult(Query::HYDRATE_OBJECT);
        return ($res);
    }

    public function getFastObservationsQb()
    {
        return $this->buildObservationQuery()->select('partial o.{eseSeqno,precisionFlag,creDat,isconfidential,latDec,lonDec,stnSeqno}, partial st.{seqno,areaType,description,pceSeqno, code,latDec,lonDec}, partial p1.{seqno,pceSeqno,name,type}, partial p2.{seqno,pceSeqno,name,type},partial p3.{seqno,pceSeqno,name,type}, partial e.{seqno,eventDatetime, description}, partial ncy.{eseSeqno},partial s2e.{eseSeqno,scnSeqno}, partial s.{seqno,scnNumber,sex,creDat,txnSeqno}, partial t.{seqno,canonicalName,scientificNameAuthorship,taxonrank,vernacularNameEn},partial cg1.{seqno,rvLowValue,rvMeaning},partial cg2.{seqno,rvLowValue,rvMeaning},partial cg2.{seqno,rvLowValue,rvMeaning}');
    }

    public function getCompleteObservationsQb()
    {
        return $this->buildObservationQuery()->select('o,st,p1,p2,p3,e,ncy,s2e,s,t');
    }

    private function buildObservationQuery()
    {
        return $this->createQueryBuilder('o')
            ->join('o.stnSeqno', 'st')
            ->leftJoin('o.osnTypeRef', 'cg1')
            ->leftJoin('o.samplingeffortRef', 'cg2')
            ->leftJoin('st.pceSeqno', 'p1')
            ->leftJoin('p1.pceSeqno', 'p2')
            ->leftJoin('p2.pceSeqno', 'p3')
            ->leftJoin('p3.pceSeqno', 'p4')
            ->join('o.eseSeqno', 'e')
            ->leftJoin('e.eventDatetimeFlagRef', 'cg3')
            ->join('e.spec2events', 's2e')
            ->join('s2e.scnSeqno', 's')
            ->leftJoin('e.necropsy', 'ncy')
            ->leftJoin('s.txnSeqno', 't')
            ->addOrderBy('e.eventDatetime', 'DESC')
            ->addOrderBy('t.canonicalName', 'ASC');
    }

    public function getCompleteObservationsQbExcludeConfidential()
    {
        return $this->getCompleteObservationsQb()->andWhere('o.isconfidential = false');

    }

}
