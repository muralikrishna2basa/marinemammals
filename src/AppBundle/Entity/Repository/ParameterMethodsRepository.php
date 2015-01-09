<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class ParameterMethodsRepository extends EntityRepository
{
    public function getParameterMethodsQb($origin)
    {
        $pms =$this->createQueryBuilder('pm')
            ->orderBy('pm.name', 'ASC')
            ->where('pm.origin = :origin')
            ->setParameter('origin',$origin)
            ->getQuery()
            ->getResult();
        return $pms;
    }

    public function getParameterMethodByName($name)
    {
        $pm =$this->createQueryBuilder('pm')
            ->orderBy('pm.name', 'ASC')
            ->where('pm.name = :name')
            ->setParameter('name',$name)
            ->getQuery()
            ->getSingleResult();
        return $pm;
    }

}
