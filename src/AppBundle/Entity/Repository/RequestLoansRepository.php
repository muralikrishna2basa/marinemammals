<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class RequestLoansRepository extends EntityRepository
{

    /*public function getUserRequestsQb(\AppBundle\Entity\Users $user)
    {
        $sampleRepo = $this
            ->getEntityManager()
            ->getRepository('AppBundle:Samples');

        $sampleQb=$sampleRepo->getPartialSamplesQb();

        return   $sampleQb->addSelect('rln, u2r')
            ->leftJoin('rln.user2Requests', 'u2r')
            ->leftJoin('u2r.usrSeqno', 'usr')
            ->where('u2r.usrSeqno= :user')
            ->setParameter('user',$user);
            ->addOrderBy('i.code', 'ASC')
            ->addOrderBy('p.lastName', 'ASC');
    }*/

    public function getUserRequestsQb(\AppBundle\Entity\Users $user)
    {

        return $this->createQueryBuilder('rln')
            ->Select('partial spe.{seqno,conservationMode, analyzeDest,speType}, partial oln.{seqno}, partial lte.{seqno}, partial ogn.{code,name}, partial ncy.{eseSeqno}, partial ese.{seqno,eventDatetime}, partial s2e.{eseSeqno,scnSeqno}, partial scn.{seqno}, partial txn.{seqno,canonicalName,vernacularNameEn},partial u2r.{rlnSeqno,usrSeqno},partial rln.{seqno,status,dateRequest,studyDescription,dateRt,dateOut}, partial usr.{seqno}')
            ->leftJoin('rln.speSeqno', 'spe')
            ->leftJoin('spe.olnLteSeqno', 'oln')
            ->leftJoin('oln.lteSeqno', 'lte')
            ->leftJoin('lte.ognCode', 'ogn')
            ->leftJoin('oln.ncyEseSeqno', 'ncy')
            ->leftJoin('ncy.eseSeqno', 'ese')
            ->leftJoin('ese.spec2events', 's2e')
            ->leftJoin('s2e.scnSeqno', 'scn')
            ->leftJoin('scn.txnSeqno', 'txn')
            ->leftJoin('rln.user2Requests', 'u2r')
            ->leftJoin('u2r.usrSeqno', 'usr')
            ->where('u2r.usrSeqno= :user')
            ->setParameter('user', $user);
        /*->addOrderBy('i.code', 'ASC')
        ->addOrderBy('p.lastName', 'ASC');*/
    }

    public function getUserRequests(\AppBundle\Entity\Users $user)
    {
        return $this->getUserRequestsQb($user)->getQuery()->getResult();
    }
}
