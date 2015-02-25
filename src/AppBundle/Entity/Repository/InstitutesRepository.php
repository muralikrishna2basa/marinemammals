<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class InstitutesRepository extends EntityRepository
{
    public function getAll()
    {
        $qb = $this->createQueryBuilder('i')
            ->select('i')
            ->addOrderBy('i.code', 'ASC');

        return $qb->getQuery()
            ->getResult();
    }
}

