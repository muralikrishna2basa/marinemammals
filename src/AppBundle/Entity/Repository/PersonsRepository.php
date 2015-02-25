<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class PersonsRepository extends EntityRepository
{
    public function getAll()
    {
        return $this->getAllPersonsQb()->getQuery()
            ->getResult();
    }

    public function getAllPersonsQb()
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->addSelect('i')
            ->leftJoin('p.iteSeqno', 'i')
            ->addOrderBy('i.code', 'ASC')
            ->addOrderBy('p.lastName', 'ASC');
    }
}
