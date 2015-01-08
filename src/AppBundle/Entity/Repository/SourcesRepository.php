<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class SourcesRepository extends EntityRepository
{
    public function getAllSources()
    {
		$qb = $this->createQueryBuilder('s')
		->select('s')
        ->addOrderBy('s.name', 'ASC');

        return $qb->getQuery()
                  ->getResult();
    }
}
