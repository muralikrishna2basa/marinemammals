<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query;

class ObservationsRepository extends EntityRepository
{

    public function removeDoubles($res){
        foreach ($res as $i => $r ){
            if(get_class($r)==='AppBundle\Entity\Spec2Events'){
                unset($res[$i]);
            }
        }
        return $res;
    }

    public function getCompleteObservation()
    {
        $res=$this->getCompleteObservationQb()->getQuery()->getResult(Query::HYDRATE_OBJECT); //unfortunately, hydrate object is needed to make use of the bidirectional asociations!
        return $this->removeDoubles($res);
    }

    public function getCompleteObservationQb()
    {
        return $this->createQueryBuilder('o')
            ->select('partial o.{eseSeqno,osnType,precisionFlag,creDat,isconfidential,samplingeffort,latDec,lonDec}, partial st.{seqno,areaType,description,pceSeqno, code,latDec,lonDec}, partial p1.{seqno,pceSeqno,name,type}, partial p2.{seqno,pceSeqno,name,type},partial p3.{seqno,pceSeqno,name,type}, partial e.{seqno,eventDatetime,eventDatetimeFlag, description}, partial s2e.{eseSeqno,scnSeqno}, partial s.{seqno,scnNumber,sex,creDat,txnSeqno}, partial t.{seqno,canonicalName,scientificNameAuthorship,taxonrank,vernacularNameEn}')
            //->select('o, st,p1,p2,p3,e,s2e,s,t')
            ->leftJoin('o.stnSeqno', 'st')
            ->leftJoin('st.pceSeqno', 'p1')
            ->innerJoin('p1.pceSeqno', 'p2')
            ->innerJoin('p2.pceSeqno', 'p3')
            ->innerJoin('o.eseSeqno', 'e')
            ->innerJoin('e.spec2events', 's2e')
            //->innerJoin('AppBundle\Entity\Spec2Events', 's2e', Expr\Join::WITH, 's2e.eseSeqno = e.seqno')
            ->leftJoin('s2e.scnSeqno', 's')
            ->leftJoin('s.txnSeqno', 't');
    }
}
