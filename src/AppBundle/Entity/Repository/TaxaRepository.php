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
}
