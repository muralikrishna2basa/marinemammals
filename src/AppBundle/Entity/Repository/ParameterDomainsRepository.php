<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class ParameterDomainsRepository extends EntityRepository
{
    public function getParameterDomainsByMethodName($name)
    {
        return $this->getParameterDomainsByMethodNameQb($name)
            ->getQuery()
            ->getResult();
    }

    public function getParameterDomainsByMethodNameQb($name)
    {
        return $this->createQueryBuilder('pd')
            ->select('pd')
            ->addSelect('pm')
            ->leftJoin('pd.pmdSeqno', 'pm')
            ->where('pm.name = :name')
            ->setParameter('name',$name);
    }
}
