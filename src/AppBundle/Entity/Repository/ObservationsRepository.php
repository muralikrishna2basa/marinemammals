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

    public function getCompleteObservation()
    {
        $res=$this->getCompleteObservationQb()->getQuery()->getResult(Query::HYDRATE_OBJECT); //unfortunately, hydrate object is needed to make use of the bidirectional asociations!
        //return $this->removeDoubles($res);
        return($res);

        /*$query = $this->getEntityManager()->createQuery('select o from AppBundle:Observations o join o.eseSeqno e join AppBundle:Spec2Events s2e with s2e.eseSeqno=e.seqno join AppBundle:Specimens s with s.seqno=s2e.scnSeqno join s.txnSeqno t');
        //$query->setMaxResults(200);
        return $query->getResult(Query::HYDRATE_OBJECT);*/

        //$a= "SELECT o, st,p1,p2,p3,e,s2e,s,t FROM AppBundle\Entity\Observations o LEFT JOIN o.stnSeqno st LEFT JOIN st.pceSeqno p1 INNER JOIN p1.pceSeqno p2 INNER JOIN p2.pceSeqno p3 INNER JOIN o.eseSeqno e INNER JOIN e.spec2events s2e INNER JOIN s2e.scnSeqno s INNER JOIN s.txnSeqno t ORDER BY e.eventDatetime DESC, t.canonicalName ASC";
    }

    public function getCompleteObservationQb()
    {
        return $this->createQueryBuilder('o')
            //->select('partial o.{eseSeqno,osnType,precisionFlag,creDat,isconfidential,samplingeffort,latDec,lonDec,stnSeqno}, partial st.{seqno,areaType,description,pceSeqno, code,latDec,lonDec}, partial p1.{seqno,pceSeqno,name,type}, partial p2.{seqno,pceSeqno,name,type},partial p3.{seqno,pceSeqno,name,type}, partial e.{seqno,eventDatetime,eventDatetimeFlag, description}, partial s2e.{eseSeqno,scnSeqno}, partial s.{seqno,scnNumber,sex,creDat,txnSeqno}, partial t.{seqno,canonicalName,scientificNameAuthorship,taxonrank,vernacularNameEn}')
            ->select('o, st,p1,p2,p3,e,s2e,s,t')
            ->join('o.stnSeqno', 'st')
            ->leftJoin('st.pceSeqno', 'p1')
            ->leftJoin('p1.pceSeqno', 'p2')
            ->leftJoin('p2.pceSeqno', 'p3')
            ->join('o.eseSeqno', 'e')
            ->join('e.spec2events', 's2e')
            //->innerJoin('AppBundle\Entity\Spec2Events', 's2e', Expr\Join::WITH, 's2e.eseSeqno = e.seqno')
            ->join('s2e.scnSeqno', 's')
            ->leftJoin('s.txnSeqno', 't')
            ->addOrderBy('e.eventDatetime', 'DESC')
            ->addOrderBy('t.canonicalName', 'ASC');
    }
}
