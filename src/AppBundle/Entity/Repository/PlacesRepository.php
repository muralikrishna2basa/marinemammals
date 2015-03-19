<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\ResultSetMapping;

class PlacesRepository extends EntityRepository
{
    public function getAll()
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p')
            ->addOrderBy('p.pceSeqno', 'ASC')
            ->addOrderBy('p.name', 'ASC');
        return $qb->getQuery()
            ->getResult();
    }

    private function getBasicResultMapping()
    {
        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('AppBundle:Places', 'p');
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

    public function getAllBelgianPlacesWithAStation()
    {
        $rsm = $this->getBasicResultMapping();
        $query = $this->getEntityManager()->createNativeQuery("SELECT seqno, pce_seqno, name, type, cre_dat, cre_user, mod_dat, mod_user FROM PLACES WHERE seqno IN (SELECT DISTINCT p.seqno FROM Places p LEFT JOIN stations s ON s.pce_seqno=p.seqno WHERE s.seqno IS NOT NULL AND LEVEL!=1 CONNECT BY PRIOR p.seqno = p.pce_seqno START WITH p.NAME='BE') order by type,name", $rsm);

        return $query->getResult();
    }

    private function getAllPlaces($root, $level)
    {
        $rsm = $this->getBasicResultMapping();

        $query = $this->getEntityManager()->createNativeQuery("SELECT seqno, pce_seqno, name, type, cre_dat, cre_user, mod_dat, mod_user FROM PLACES WHERE seqno IN (SELECT DISTINCT p.seqno FROM Places p WHERE LEVEL=" . $level . " CONNECT BY PRIOR p.seqno = p.pce_seqno START WITH p.NAME='" . $root . "') order by type,name", $rsm);
        $r = $query->getResult();
        return $r;
    }

    private function getAllPlacesWithAStation($root, $level)
    {
        $rsm = $this->getBasicResultMapping();

        $query = $this->getEntityManager()->createNativeQuery("SELECT seqno, pce_seqno, name, type, cre_dat, cre_user, mod_dat, mod_user FROM PLACES WHERE seqno IN (SELECT DISTINCT p.seqno FROM Places p LEFT JOIN stations s ON s.pce_seqno=p.seqno WHERE s.seqno IS NOT NULL AND LEVEL=" . $level . " CONNECT BY PRIOR p.seqno = p.pce_seqno START WITH p.NAME='" . $root . "') order by type,name", $rsm);
        $r = $query->getResult();
        return $r;
    }

    public function getAllBelgianPlacesAtLevel2()
    {
        return $this->getAllPlaces('BE', 2);
    }

    public function getAllBelgianPlacesAtLevel3()
    {
        return $this->getAllPlaces('BE', 3);
    }

    public function getAllBelgianPlacesAtLevel4WithAStation()
    {
        return $this->getAllPlacesWithAStation('BE', 4);
    }

    public function getAllPlacesAtLevel2()
    {
        return $this->getAllPlaces('WORLD', 2);
    }

    public function getAllPlacesAtLevel3()
    {
        return $this->getAllPlaces('WORLD', 3);
    }

    public function getAllPlacesAtLevel4()
    {
        return $this->getAllPlaces('WORLD', 4);
    }

    public function getAllPlacesAtLevel5WithAStation()
    {
        return $this->getAllPlacesWithAStation('WORLD', 5);
    }

    /*    public function getAllBelgianPlacesWithAStationAtLevel1(){
   $rsm = new ResultSetMapping();
   $query = $this->getEntityManager()->createNativeQuery("SELECT DISTINCT p1.NAME, p1.TYPE FROM places p1 LEFT JOIN places p2 ON p1.pce_seqno=p2.seqno LEFT JOIN places p3 ON p2.pce_seqno=p3.seqno LEFT JOIN places p4 ON p3.pce_seqno=p4.seqno left JOIN stations s ON s.pce_seqno=p1.seqno WHERE p1.NAME NOT IN ('DE','FR','GB','NL','PT') AND p2.NAME NOT   IN ('DE','FR','GB','NL','PT') AND p3.NAME NOT   IN ('DE','FR','GB','NL','PT') AND p4.NAME NOT   IN ('DE','FR','GB','NL','PT') AND s.seqno is not NULL ORDER BY p1.TYPE,p1.NAME;", $rsm);

   return $query->getResult();
  }

   public function getAllBelgianPlacesWithAStationAtLevel2(){
    $rsm = new ResultSetMapping();
    $query = $this->getEntityManager()->createNativeQuery("SELECT distinct p2.name,p2.type FROM places p1 LEFT JOIN places p2 ON p1.pce_seqno=p2.seqno LEFT JOIN places p3 ON p2.pce_seqno=p3.seqno LEFT JOIN places p4 ON p3.pce_seqno=p4.seqno left JOIN stations s ON s.pce_seqno=p2.seqno WHERE p1.NAME NOT  IN ('DE','FR','GB','NL','PT') AND p2.NAME NOT  IN ('DE','FR','GB','NL','PT') AND p3.NAME NOT  IN ('DE','FR','GB','NL','PT') AND p4.NAME NOT  IN ('DE','FR','GB','NL','PT') order by p2.type, p2.name;", $rsm);

   return $query->getResult();
  }*/

    public function getAllPlacesParentQb()
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p')
            ->addSelect('p2')
            ->leftJoin('p.pceSeqno', 'p2')
            ->addOrderBy('p2.name', 'ASC')
            ->addOrderBy('p.name', 'ASC');
        return $qb;
    }

    public function getAllCountries()
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p')
            ->addOrderBy('p.name', 'ASC')
            ->where("p.type = 'CTY'");
        return $qb->getQuery()
            ->getResult();
    }
}
