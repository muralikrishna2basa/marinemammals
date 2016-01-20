<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/03/15
 * Time: 14:17
 */

namespace AppBundle\ControllerHelper;


Class ObservationIndexPropertiesSet extends GettablePropertiesSet
{
    public function __construct()
    {
        $this->functions = array(
            'location type' => function ($observation) {
                $stn= $observation->getStnSeqno();
                if( isset($stn) ) {
                    return $stn->getAreaType();
                } else {
                    return '';
                }
            },
            'place' => function ($observation) {
                $stn= $observation->getStnSeqno();
                if( isset($stn) ) {
                    return $stn->getPlaceName();
                } else {
                    return '';
                }
            },
            'location' => function ($observation) {
                $stn= $observation->getStnSeqno();
                if( isset($stn) ) {
                    return $stn->getDescription();
                } else {
                    return '';
                }
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