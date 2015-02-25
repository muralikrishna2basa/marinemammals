<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class SourcesRepository extends EntityRepository
{
    public function getAll()
    {
		$qb = $this->createQueryBuilder('s')
		->select('s')
        ->addOrderBy('s.name', 'ASC');

        return $qb->getQuery()
                  ->getResult();
    }
}
