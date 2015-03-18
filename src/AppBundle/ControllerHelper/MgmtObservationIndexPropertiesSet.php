<?php

namespace AppBundle\ControllerHelper;


Class MgmtObservationIndexPropertiesSet extends PropertiesSet
{
    public function __construct()
    {
        $this->functions = array(
            'isconfidential' => function ($observation) {
                return $observation->getIsconfidential();
            },
            'location type' => function ($observation) {
                return $observation->getStnSeqno()->getAreaType();
            },
            'country' => function ($observation) {
                return $observation->getStnSeqno()->getCountry();
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
            },
            'observationId' => function ($observation) {
                return $observation->getEseSeqno()->getSeqno();
            },
            'specimenId' => function ($observation) {
                return $observation->getEseSeqno()->getSpec2Events()->getScnSeqno()->getSeqno();
            }
        );
    }
}