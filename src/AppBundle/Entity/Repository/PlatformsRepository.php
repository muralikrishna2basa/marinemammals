<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class PlatformsRepository extends EntityRepository
{
    public function getAll()
    {
		$qb = $this->createQueryBuilder('p')
		->select('p')
        ->addOrderBy('p.name', 'ASC');

        return $qb->getQuery()
                  ->getResult();
    }
}
