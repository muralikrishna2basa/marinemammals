<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class PlatformsRepository extends EntityRepository
{
    public function getAll()
    {
        return $this->getAllPlatformsQb()->getQuery()
                  ->getResult();
    }

    public function getAllPlatformsQb()
    {
       return $this->createQueryBuilder('p')
            ->select('p')
            ->addOrderBy('p.name', 'ASC');
    }
}
