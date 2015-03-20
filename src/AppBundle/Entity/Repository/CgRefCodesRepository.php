<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class CgRefCodesRepository extends EntityRepository
{
    public function getRefCodes($domain)
    {
        return $this->getRefCodesQb($domain)->getQuery()->getResult();
    }

    public function getRefCodesQb($domain)
    {
        return $this->createQueryBuilder('cgr')
            ->orderBy('cgr.rvLowValue', 'ASC')
            ->where('cgr.rvDomain = :domain')
            ->setParameter('domain',$domain);
    }

    public function getAll()
    {
        $types =$this->createQueryBuilder('cgr')
            ->select('cgr')
            ->orderBy('cgr.rvLowValue', 'ASC')
            ->getQuery()
            ->getResult();
        return $types;
    }
}
