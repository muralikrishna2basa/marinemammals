<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class TaxaRepository extends EntityRepository
{
    public function getAll()
    {
        return $this->getAllTaxaQb()->getQuery()
                  ->getResult();
    }

    public function getAllTaxaQb()
    {
        return $this->createQueryBuilder('t')
            ->select('t')
            ->addOrderBy('t.taxonrank', 'ASC')
            ->addOrderBy('t.canonicalName', 'ASC');
    }

    public function getAllTaxonranks()
    {
        $qb = $this->createQueryBuilder('t')
            ->select('t.taxonrank')
            ->distinct()
            ->where('t.taxonrank is not null')
            ->addOrderBy('t.taxonrank', 'ASC');

        return $qb->getQuery()
            ->getResult();
    }
}
