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

    public function getCompleteObservationsQb()
    {
        return $this->createQueryBuilder('o')
            //->select('partial o.{eseSeqno,osnType,precisionFlag,creDat,isconfidential,samplingeffort,latDec,lonDec,stnSeqno}, partial st.{seqno,areaType,description,pceSeqno, code,latDec,lonDec}, partial p1.{seqno,pceSeqno,name,type}, partial p2.{seqno,pceSeqno,name,type},partial p3.{seqno,pceSeqno,name,type}, partial e.{seqno,eventDatetime,eventDatetimeFlag, description}, partial s2e.{eseSeqno,scnSeqno}, partial s.{seqno,scnNumber,sex,creDat,txnSeqno}, partial t.{seqno,canonicalName,scientificNameAuthorship,taxonrank,vernacularNameEn}')
            ->select('o,st,p1,p2,p3,e,ncy,s2e,s,t')
            ->join('o.stnSeqno', 'st')
            ->leftJoin('AppBundle\Entity\CgRefCodes', 'cgr',\Doctrine\ORM\Query\Expr\Join::WITH,  'o.osnType=cgr.rvLowValue')
            ->leftJoin('st.pceSeqno', 'p1')
            ->leftJoin('p1.pceSeqno', 'p2')
            ->leftJoin('p2.pceSeqno', 'p3')
            ->join('o.eseSeqno', 'e')
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
