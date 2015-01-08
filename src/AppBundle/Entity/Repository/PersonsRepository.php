<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class PersonsRepository extends EntityRepository
{
    public function getAllPersons()
    {
		$qb = $this->createQueryBuilder('p')
		->select('p')
            ->addSelect('i')
            ->leftJoin('p.iteSeqno', 'i')
		->addOrderBy('i.code', 'ASC')
        ->addOrderBy('p.lastName', 'ASC');

        return $qb->getQuery()
                  ->getResult();
    }
}
