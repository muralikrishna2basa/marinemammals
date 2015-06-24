<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class GroupsRepository extends EntityRepository
{
    public function getAll()
    {
        return $this->getAllGroupsQb()->getQuery()
            ->getResult();
    }

    public function findByName($name){
        return $this->getAllGroupsQb()
            ->where('g.name=:name')
            ->setParameter('name',$name)
            ->getQuery()->getSingleResult();
    }

    public function getAllGroupsQb()
    {
        return $this->createQueryBuilder('g')
            ->select('g')
            ->addOrderBy('g.name', 'ASC');
    }
}
