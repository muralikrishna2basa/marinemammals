<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class TaxaRepository extends EntityRepository
{
    public function getAllTaxa()
    {
		$qb = $this->createQueryBuilder('t')
		->select('t')
		->addOrderBy('t.taxonrank', 'ASC')
        ->addOrderBy('t.canonicalName', 'ASC');

        return $qb->getQuery()
                  ->getResult();
    }
}
