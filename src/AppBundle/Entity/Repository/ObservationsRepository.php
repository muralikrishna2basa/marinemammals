<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class ObservationsRepository extends EntityRepository
{
    public function getCompleteObservation()
    {
        $query = $this->getEntityManager()->createQuery('select o from AppBundle:Observations o join o.eseSeqno e join AppBundle:Spec2Events s2e with s2e.eseSeqno=e.seqno join AppBundle:Specimens s with s.seqno=s2e.scnSeqno join s.txnSeqno t');
        //$query->setMaxResults(200);
        return $query->getResult();
    }
}

//        $query = $this->getEntityManager()->createQuery('select o,e from AppBundle:Observations o join AppBundle:EventStates e with o.eseSeqno=e.seqno');