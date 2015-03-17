<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/03/15
 * Time: 14:17
 */

namespace AppBundle\Controller;


Class ObservationIndexPropertiesSet extends PropertiesSet
{
    public function __construct()
    {
        $this->functions = array(
            'location type' => function ($observation) {
                return $observation->getStnSeqno()->getAreaType();
            },
            'place' => function ($observation) {
                return $observation->getStnSeqno()->getPlaceName();
            },
            'location' => function ($observation) {
                return $observation->getStnSeqno()->getDescription();
            },
            'decimalLatitude' => function ($observation) {
                return $observation->getLatDec();
            },
            'decimalLongitude' => function ($observation) {
                return $observation->getLonDec();
            },
            'eventDate' => function ($observation) {
                return $observation->getEseSeqno()->getEventDatetime()->format("d/m/Y");
            },
            'observationType' => function ($observation) {
                return $observation->getOsnType();
            },
            'scientificName' => function ($observation) {
                return $observation->getEseSeqno()->getSpec2Events()->getScnSeqno()->getTxnSeqno()->getCanonicalName();
            },
            'vernacularName' => function ($observation) {
                return $observation->getEseSeqno()->getSpec2Events()->getScnSeqno()->getTxnSeqno()->getVernacularNameEn();
            }
        );
    }
}