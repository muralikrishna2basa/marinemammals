<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

require '/home/thomas/PhpstormProjects/mm/src/AppBundle/Resources/views/Legacy/functions/getAuthDb.php';


class NecropsiesRepository extends EntityRepository
{

    public function findBySeqno($seqno)
    {
        $qb = $this->createQueryBuilder('s')
            ->select('s')
            ->where('s.seqno = :seqno')
            ->setParameter('seqno', $seqno);

        $res = $qb->getQuery()
            ->getSingleResult(Query::HYDRATE_OBJECT);
        return $res;
    }

    public function getCompleteNecropsies()
    {
        return $this->getCompleteNecropsiesQb()->getQuery()
            ->getResult();
    }

    public function getCompleteNecropsiesQb()
    {
        return $this->buildNecropsyQuery()->select('s,oln,lte,ogn,ncy,ese,s2e,scn,txn');
    }

    public function getPartialNecropsies()
    {
        return $this->getPartialNecropsiesQb()->getQuery()
            ->getScalarResult();
    }

    public function getPartialNecropsiesQb()
    {
        return $this->buildNecropsyQuery()->select('partial oln.{seqno, description}, partial lte.{seqno,processus}, partial ogn.{code,name}, partial ncy.{eseSeqno,refAut,refLabo}, partial ese.{seqno,eventDatetime,eventDatetimeFlagRef}, partial s2e.{eseSeqno,scnSeqno}, partial scn.{seqno}, partial txn.{seqno,canonicalName,vernacularNameEn}');
        /*->addSelect('(SELECT MAX(ese2.eventDatetime) AS event_datetime
        FROM AppBundle:EventStates ese2
        JOIN ese2.observation o
        JOIN ese2.spec2events s2e2
        WHERE ese.seqno = ese2.seqno GROUP BY s2e2.scnSeqno) as date_found'
        );*/
    }

    private function getBasicResultMapping()
    {
        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('AppBundle:Necropsy', 'ncy');
        $rsm->addFieldResult('p', 'SEQNO', 'seqno');
        $rsm->addJoinedEntityResult('AppBundle\Entity\Places', 'p1', 'p', 'pceSeqno');
        $rsm->addFieldResult('p', 'NAME', 'name');
        $rsm->addFieldResult('p', 'TYPE', 'type');
        $rsm->addFieldResult('p', 'CRE_DAT', 'creDat');
        $rsm->addFieldResult('p', 'CRE_USER', 'creUser');
        $rsm->addFieldResult('p', 'MOD_DAT', 'modDat');
        $rsm->addFieldResult('p', 'MOD_USER', 'modUser');
        return $rsm;
    }


    private function buildNecropsyQuery()
    {
        return $this->createQueryBuilder('ncy')
            ->leftJoin('ncy.olnSeqno', 'oln')
            ->leftJoin('oln.lteSeqno', 'lte')
            ->leftJoin('lte.ognCode', 'ogn')
            ->leftJoin('ncy.eseSeqno', 'ese')
            ->leftJoin('ese.spec2events', 's2e')
            ->leftJoin('s2e.scnSeqno', 'scn')
            ->leftJoin('scn.txnSeqno', 'txn');
    }

    public function getPartialNecropsiesNativeQuery($filter)
    {

        $config = array(
            'driver'    => 'mysql', // Db driver
            'host'      => 'localhost',
            'database'  => 'your-database',
            'username'  => 'root',
            'password'  => 'your-password',
            'charset'   => 'utf8', // Optional
            'collation' => 'utf8_unicode_ci', // Optional
            'prefix'    => 'cb_', // Table prefix, optional
            'options'   => array( // PDO constructor options, optional
                PDO::ATTR_TIMEOUT => 5,
                PDO::ATTR_EMULATE_PREPARES => false,
            ),
        );

        new Connection('mysql', $config, 'QB');
        $query = QB::query('select * from cb_my_table where age = 12');
       //$connection=new Connection();
        //$rsm = $this->getBasicResultMapping();
        $query="SELECT distinct NECROPSY_SEQNO,FOUND_DATE,NECROPSY_DATE,DATETIME_FLAG,DESCRIPTION,EVENTCREDAT,SPECIMENSEQNO,IDENTIFICATION_CERTAINTY,NECROPSY_TAG,RBINS_TAG,CANONICAL_NAME,VERNACULAR_NAME_EN,SPECIMENSEX,REF_AUT,REF_LABO,NAME,E2P_TYPE,FIRST_NAME,LAST_NAME,PERSONSEX from BIOLIB_OWNER.SELECT_NICE_NECROPSY";
        $query=$this->filterQuery($query,$filter);

        $conn = oci_connect($connection->user, $connection->pass, $connection->alias, 'AL32UTF8');

        $st_handle = oci_parse($conn,  $query);
        oci_execute($st_handle);
        $result=array();
       //oci_fetch_all ($st_handle,$result, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        while ($row=oci_fetch_assoc($st_handle)) {
            $row['FOUND_DATE']=\DateTime::createFromFormat('d/m/Y H:i:s', $row['FOUND_DATE']);
            $row['NECROPSY_DATE']=\DateTime::createFromFormat('d/m/Y H:i:s', $row['NECROPSY_DATE']);
            $row['EVENTCREDAT']=\DateTime::createFromFormat('d/m/Y H:i:s', $row['EVENTCREDAT']);
            array_push($result,$row);
        }
        return $result;
    }

private function filterQuery($query,$filter){


}

    public function extendQbByFilter($query, $filter){

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
            if ($conservationMode) {
                $filterBuilder->andWhere('s.conservationMode=:conservationMode');
                $filterBuilder->setParameter('conservationMode', $conservationMode);
            }
        }
        return $filterBuilder;//->getQuery()->getScalarResult();
    }


    public function getNecropsiesWithPagination($order_by = array(), $offset = 0, $limit = 0, $scalar = true)
    {
        $q = $this->getNecropsiesWithPaginationQb($order_by, $offset, $limit);
        if ($scalar) {
            return $q->getScalarResult();
        } else {
            return $q->getResult();
        }
    }


    public function getNecropsiesWithPaginationQb($order_by = array(), $offset = 0, $limit = 0)
    {
        $qb = $this->getPartialNecropsiesQb();
        return $this->getNecropsiesWithPaginationQbbyQb($qb, $order_by, $offset, $limit);
    }

    public function getNecropsiesWithPaginationQbbyQb($qb, $order_by = array(), $offset = 0, $limit = 0)
    {
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
        return $qb;
    }

    public function getNecropsyCount()
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

    public function getNecropsyCountByQb($qb)
    {
        $qb->add('select', $qb->expr()->count('s'));
        return $qb->getQuery()->getSingleScalarResult();
    }
}
