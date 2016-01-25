<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class MediasRepository extends EntityRepository
{

    public function getMostRecentPhotos($amount){
        return $this->getMostRecentPhotosQb($amount)->getQuery()
            ->getResult();

    }

    public function getMostRecentPhotosQb($amount)
    {
        return $this->createQueryBuilder('m')
            ->select('m')
            ->addSelect('e')
            ->leftJoin('m.eseSeqno','e')
            ->addOrderBy('e.eventDatetime', 'DESC')
            ->where("e is not null")
            ->andWhere("m.isconfidential = false")
            ->setMaxResults($amount);
    }
}
