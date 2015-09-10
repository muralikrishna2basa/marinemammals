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

    public function getAllEuropeanTaxaQb()
    {
        return $this->createQueryBuilder('t')
            ->select('t')
            ->addOrderBy('t.taxonrank', 'ASC')
            ->addOrderBy('t.canonicalName', 'ASC')
            ->where('t.presentInEurope = true');
    }

    public function getAllNSTaxaOnlyCollectiveSpeciesQb()
    {
        return $this->createQueryBuilder('t')
            ->select('t')
            ->addOrderBy('t.taxonrank', 'ASC')
            ->where('t.presentInNorthSea= true')
            ->andWhere("t.taxonrank != 'species'");
    }

    public function getAllNSTaxaWOCollectiveSpeciesQb()
    {
        return $this->createQueryBuilder('t')
            ->select('t')
            ->where('t.presentInNorthSea= true')
            ->andWhere("t.taxonrank = 'species'");

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
