<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 18/03/15
 * Time: 16:21
 */

namespace AppBundle\ControllerHelper;

use AppBundle\Entity\Observations;
use AppBundle\Entity\EventStates;
use AppBundle\Entity\Event2Persons;
use AppBundle\Entity\Spec2Events;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class NecropsiesProvider// implements ContainerAwareInterface
{

    private $doctrine;
    private $repo;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
        $this->repo = $this->doctrine->getRepository('AppBundle:Samples');
    }



    public function extendQbByFilter($qb, $filter){

        $filterBuilder=$qb;
        if ($filter !== null) {
            $eventDatetimeStart = null;
            $eventDatetimeStop = null;
            $osnTypeRef = null;
            $stn = null;
            $txn = null;
            $refAut = null;
            $refLabo = null;
            $processus = null;
            $ognCode = null;
            $conservationMode = null;

            if (array_key_exists('eventDatetimeStart', $filter)) {
                $eventDatetimeStart = $filter['eventDatetimeStart'];
            }
            if (array_key_exists('eventDatetimeStop', $filter)) {
                $eventDatetimeStop = $filter['eventDatetimeStop'];
            }
            if (array_key_exists('osnTypeRef', $filter)) {
                $osnTypeRef = $filter['osnTypeRef'];
            }
            if (array_key_exists('stnSeqno', $filter)) {
                $stn = $filter['stnSeqno'];
            }
            if (array_key_exists('txnSeqno', $filter)) {
                $txn = $filter['txnSeqno'];
            }
            if (array_key_exists('refAut', $filter)) {
                $refAut = $filter['refAut'];
            }
            if (array_key_exists('refLabo', $filter)) {
                $refLabo = $filter['refLabo'];
            }
            if (array_key_exists('processus', $filter)) {
                $processus = $filter['processus'];
            }
            if (array_key_exists('ognCode', $filter)) {
                $ognCode = $filter['ognCode'];
            }

            $osnType = null;
            if ($osnTypeRef !== null) {
                $osnType = $osnTypeRef->getRvLowValue();
            }

            if ($eventDatetimeStart && $eventDatetimeStop) {
                $filterBuilder->andWhere('e.eventDatetime>=:eventDatetimeStart and e.eventDatetime<=:eventDatetimeStop');
                $filterBuilder->setParameter('eventDatetimeStart', $eventDatetimeStart);
                $filterBuilder->setParameter('eventDatetimeStop', $eventDatetimeStop);
            }
            if ($osnType) {
                $filterBuilder->andWhere('cg1.rvLowValue=:osnType');
                $filterBuilder->setParameter('osnType', $osnType);
            }
            if ($stn) {
                $filterBuilder->andWhere('o.stnSeqno=:stnSeqno');
                $filterBuilder->setParameter('stnSeqno', $stn);
            }
            if ($txn) {
                $filterBuilder->andWhere('txn.canonicalName=:canonicalName');
                $filterBuilder->setParameter('canonicalName', $txn->getCanonicalName());
            }
            if ($refAut) {
                $filterBuilder->andWhere('ncy.refAut=:refAut');
                $filterBuilder->setParameter('refAut', $refAut);
            }
            if ($refLabo) {
                $filterBuilder->andWhere('ncy.refLabo=:refLabo');
                $filterBuilder->setParameter('refLabo', $refLabo);
            }
            if ($processus) {
                $filterBuilder->andWhere('lte.processus=:processus');
                $filterBuilder->setParameter('processus', $processus);
            }
            if ($ognCode) {
                $filterBuilder->andWhere('ogn.ognCode=:ognCode');
                $filterBuilder->setParameter('ognCode', $ognCode);
            }
        }
        return $filterBuilder;//->getQuery()->getScalarResult();
    }

    public function extendQbByPagination($qb, $order_by = array(), $offset = 0, $limit = 0)
    {
        return $this->repo->getSamplesWithPaginationQbbyQb($qb, $order_by, $offset, $limit);
        //return $this->loadSamplesByFilterQb($filter, $filterBuilder);
        //getSamplesWithPaginationQbbyQb($qb, $order_by = array(), $offset = 0, $limit = 0)
    }

}