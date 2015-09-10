<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class OrgansRepository extends EntityRepository
{
    public function getAllOrgansQb()
    {
		return $this->createQueryBuilder('o')
		->select('o')
        ->addOrderBy('o.name', 'ASC');

    }

    public function getAllOrgans()
    {
        return $this->getAllOrgansQb()->getQuery()
            ->getResult();
    }

}
