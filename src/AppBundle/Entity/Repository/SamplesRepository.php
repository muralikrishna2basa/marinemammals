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
        return $this->buildSampleQuery()->select('s,oln,lt,ogn,ncy,ese,s2e,scn,txn');
    }

    public function getFastSamples()
    {
        return $this->getFastSamplesQb()->getQuery()
            ->getScalarResult();
    }

    public function getFastSamplesQb()
    {
       /* $subquery = $this->createQueryBuilder('ese')
            ->select('partial ese.{seqno}, MAX(ese.eventDatetime) AS event_datetime')
            ->from('AppBundle:EventStates','ese')
            ->leftJoin('ese.observation','o')
            ->leftJoin('ese.spec2events','s2e')
            ->groupBy('s2e.snSeqno');*/

        return $this->buildSampleQuery()->select('partial s.{seqno,conservationMode, analyzeDest,speType}, partial ogn.{code,name},partial txn.{seqno,canonicalName,vernacularNameEn},partial ese.{seqno,eventDatetime} ')
            ->addSelect('(SELECT MAX(ese2.eventDatetime) AS event_datetime
            FROM AppBundle:EventStates ese2
            JOIN ese2.observation o
            JOIN ese2.spec2events s2e2
            WHERE ese.seqno = ese2.seqno GROUP BY s2e2.scnSeqno) as date_found'
            );
    }


/*
    private function getMaxObsDateSpecimen(){
        $rsm = $this->getResultMapping();
        $query = $this->getEntityManager()->createNativeQuery("select c.scn_seqno,b.seqno,max(b.event_datetime) as event_datetime from
observations a,
event_states b,
spec2events c
where
a.ese_seqno = b.seqno
and
c.ese_seqno = b.seqno
group by
c.scn_seqno,b.seqno;", $rsm);

        return $query->;
    }*/


    private function buildSampleQuery()
    {
        /*$subquery = $this->createQueryBuilder('ese')
        ->select('partial ese.{seqno}, MAX(ese.eventDatetime) AS event_datetime')
            ->from('AppBundle:EventStates','ese')
            ->leftJoin('ese.observation','o')
            ->leftJoin('ese.spec2events','s2e')
        ->groupBy('s2e.snSeqno');
*/

        return $this->createQueryBuilder('s')
            ->leftJoin('s.olnLteSeqno', 'oln')
            ->leftJoin('oln.lteSeqno','lt')
            ->leftJoin('lt.ognCode','ogn')
            ->leftJoin('oln.ncyEseSeqno','ncy')
            ->leftJoin('ncy.eseSeqno','ese')
            ->leftJoin('ese.spec2events','s2e')
            ->leftJoin('s2e.scnSeqno','scn')
            ->leftJoin('scn.txnSeqno','txn');
    }

    private function getResultMapping()
    {
        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('AppBundle:Samples', 'spe');
        /*$rsm->addJoinedEntityResult('AppBundle\Entity\OrganLesions', 'oln', 'spe', 'olnLteSeqno');
        $rsm->addJoinedEntityResult('AppBundle\Entity\LesionTypes', 'lte', 'oln', 'lteSeqno');
        $rsm->addJoinedEntityResult('AppBundle\Entity\Organs', 'ogn', 'lte', 'ognCode');
        $rsm->addJoinedEntityResult('AppBundle\Entity\Necropsies', 'ncy', 'oln', 'ncyEseSeqno');
        $rsm->addJoinedEntityResult('AppBundle\Entity\EventStates', 'ese', 'ncy', 'eseSeqno');
        $rsm->addJoinedEntityResult('AppBundle\Entity\Spec2Events', 's2e', 'ese', 'spec2events');
        $rsm->addJoinedEntityResult('AppBundle\Entity\Specimens', 'scn', 's2e', 'scnSeqno');
        $rsm->addJoinedEntityResult('AppBundle\Entity\Taxa', 'txn', 'scn', 'txnSeqno');*/

        $rsm->addFieldResult('spe', 'analyze_dest', 'analyzeDest');
        $rsm->addFieldResult('spe', 'conservation_mode', 'conservationMode');
        $rsm->addFieldResult('spe', 'spe_type', 'speType');
        $rsm->addFieldResult('spe', 'seqno', 'seqno');
        /*$rsm->addFieldResult('ogn', 'name', 'name');
        $rsm->addFieldResult('ogn', 'ogn_code', 'ognCode');

        $rsm->addFieldResult('ese', 'event_datetime', 'eventDatetime');
        $rsm->addScalarResult('ms', 'event_datetime');
        $rsm->addFieldResult('ese', 'seqno', 'seqno');
        $rsm->addFieldResult('txn', 'canonical_name', 'canonicalName');
        $rsm->addFieldResult('txn', 'vernacular_name_en', 'vernacularNameEn');
        $rsm->addFieldResult('txn', 'seqno', 'seqno');
        $rsm->addScalarResult('cg1', 'rv_meaning');
        $rsm->addScalarResult('cg2', 'rv_meaning');*/
        return $rsm;
    }

    public function getNativeSamples()
    {
        $rsm = $this->getResultMapping();
        $query = $this->getEntityManager()->createNativeQuery("
select
  samples.analyze_dest,
  cg1.rv_meaning,
  samples.conservation_mode,
  cg2.rv_meaning,
  samples.spe_type,
  samples.seqno,
  ogn.name,
  ogn.ogn_code,
  ese.event_datetime,
  ms.event_datetime,
  ese.seqno,
  txn.canonical_name,
  txn.vernacular_name_en,
  txn.seqno
from samples
left join lesions2sample l2s on samples.seqno = l2s.spe_seqno
left join organ_lesions oln on oln.seqno = l2s.oln_seqno
left join lesion_types lte on oln.lte_seqno = lte.seqno
left join organs ogn on lte.ogn_code = ogn.code
left join necropsies ncy on oln.ncy_ese_seqno = ncy.ese_seqno
left join event_states ese on ncy.ese_seqno = ese.seqno
left join spec2events s2e on ese.seqno = s2e.ese_seqno
left join specimens scn on s2e.scn_seqno = scn.seqno
left join taxa txn on scn.txn_seqno = txn.seqno
left join max_obs_date_specimen ms on ms.ese_seqno=ese.seqno
left join cg_ref_codes cg1 on samples.analyze_dest = cg1.rv_low_value
left join cg_ref_codes cg2 on samples.conservation_mode = cg2.rv_low_value", $rsm);

        return $query->getScalarResult();
    }
}
