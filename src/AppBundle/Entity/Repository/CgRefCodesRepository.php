<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class CgRefCodesRepository extends EntityRepository
{
    public function getRefCodes($domain)
    {
        $types =$this->createQueryBuilder('cgr')
            ->orderBy('cgr.rvLowValue', 'ASC')
            ->where('cgr.rvDomain = :domain')
            ->setParameter('domain',$domain)
            ->getQuery()
            ->getResult();
        return $types;
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
