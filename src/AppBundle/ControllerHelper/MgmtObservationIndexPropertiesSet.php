<?php

namespace AppBundle\ControllerHelper;

use \Exception;

Class MgmtObservationIndexPropertiesSet extends GettablePropertiesSet
{
    public function __construct()
    {
        $this->functions = array(
            'isconfidential' => function ($observation) {
                return $observation->getIsconfidential();
            },
            'location type' => function ($observation) {
               $stn= $observation->getStnSeqno();
                if( isset($stn) ) {
                    return $stn->getAreaType();
                } else {
                    return '';
                }
            },
            'country' => function ($observation) {
                $stn= $observation->getStnSeqno();
                if( isset($stn) ) {
                    return $stn->getCountry();
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
            'locationDecimalLatitude' => function ($observation) {
                $stn= $observation->getStnSeqno();
                if( isset($stn) ) {
                    return $stn->getLatDec();
                } else {
                    return '';
                }
            },
            'locationDecimalLongitude' => function ($observation) {
                $stn= $observation->getStnSeqno();
                if( isset($stn) ) {
                    return $stn->getLonDec();
                } else {
                    return '';
                }
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
            },
            /*specimen characteristics*/
            'scnNumber' => function ($observation) {
                return $observation->getEseSeqno()->getSpec2Events()->getScnSeqno()->getScnNumber();
            },
            'sex' => function ($observation) {
                return $observation->getEseSeqno()->getSpec2Events()->getScnSeqno()->getSex();
            },
            'mummtag' => function ($observation) {
                return $observation->getEseSeqno()->getSpec2Events()->getScnSeqno()->getMummTag();
            },
            'collectionTag' => function ($observation) {
                return $observation->getEseSeqno()->getSpec2Events()->getScnSeqno()->getNecropsyTag();
            },
            'rbinsTag' => function ($observation) {
                return $observation->getEseSeqno()->getSpec2Events()->getScnSeqno()->getRbinsTag();
            },
            'otherTag' => function ($observation) {
                return $observation->getEseSeqno()->getSpec2Events()->getScnSeqno()->getOtherTag();
            },
            'name' => function ($observation) {
                return $observation->getEseSeqno()->getSpec2Events()->getScnSeqno()->getName();
            },

            /*spec2events-specimen values*/
            'before_intervention' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Before intervention');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },
            'during_intervention' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('During intervention');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },
            'collection' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Collection');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },
            'decomposition_code' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Decomposition Code');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },

            'body_length' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Body length');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },
            'body_weight' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Body weight');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },
            'age' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Age');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },

            'nutritional_status' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Nutritional Status');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },

            'fresh_external_lesions::fresh_bite_marks' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Fresh external lesions::Fresh bite marks');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },
            'fresh_external_lesions::opened_abdomen' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Fresh external lesions::Opened abdomen');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },
            'fresh_external_lesions::stabbing_wound' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Fresh external lesions::Stabbing wound');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },
            'fresh_external_lesions::parallel_cuts' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Fresh external lesions::Parallel cuts');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },
            'fresh_external_lesions::broken_bones' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Fresh external lesions::Broken bones');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },
            'fresh_external_lesions::hyphema' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Fresh external lesions::Hyphema');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },
            'fresh_external_lesions::fin_amputation' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Fresh external lesions::Fin amputation');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },
            'fresh_external_lesions::encircling_lesion' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Fresh external lesions::Encircling lesion');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },
            'fresh_external_lesions::other_fresh_external_lesions' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Fresh external lesions::Other fresh external lesions');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },
            'fresh_external_lesions::line/net_impressions_or_cuts::tail' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Fresh external lesions::Line/net impressions or cuts::Tail');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },
            'fresh_external_lesions::line/net_impressions_or_cuts::pectoral_fin' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Fresh external lesions::Line/net impressions or cuts::Pectoral fin');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },
            'fresh_external_lesions::line/net_impressions_or_cuts::snout' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Fresh external lesions::Line/net impressions or cuts::Snout');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },
            'fresh_external_lesions::line/net_impressions_or_cuts::mouth' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Fresh external lesions::Line/net impressions or cuts::Mouth');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },
            'fresh_external_lesions::scavenger_traces::picks' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Fresh external lesions::Scavenger traces::Picks');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },
            'fresh_external_lesions::scavenger_traces::bites' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Fresh external lesions::Scavenger traces::Bites');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },
            'healing/healed_lesions::bites' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Healing/healed lesions::Bites');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },
            'healing/healed_lesions::pox-like_lesions' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Healing/healed lesions::Pox-like lesions');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },
            'healing/healed_lesions::open_warts' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Healing/healed lesions::Open warts');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },
            'healing/healed_lesions::cuts' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Healing/healed lesions::Cuts');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },
            'healing/healed_lesions::line/net_impressions' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Healing/healed lesions::Line/net impressions');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },
            'fishing_activities::static_gear_on_beach_nearby' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Fishing activities::Static gear on beach nearby');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },
            'fishing_activities::static_gear_at_sea_nearby' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Fishing activities::Static gear at sea nearby');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },
            'other_characteristics::external_parasites' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Other characteristics::External parasites');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },
            'other_characteristics::froth_from_airways' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Other characteristics::Froth from airways');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },
            'other_characteristics::fishy_smell' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Other characteristics::Fishy smell');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },
            'other_characteristics::prey_remains_in_mouth' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Other characteristics::Prey remains in mouth');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },
            'other_characteristics::remains_of_nets,_ropes,_plastic,_etc.' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Other characteristics::Remains of nets, ropes, plastic, etc.');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },
            'other_characteristics::oil_remains_on_skin' => function ($observation) {
                $sv = $observation->getEseSeqno()->getSpec2Events()->getValueByKey('Other characteristics::Oil remains on skin');
                if (isset($sv)) {
                    return $sv->getValue();
                } else {
                    return null;
                }
            },
            'description' => function ($observation) {
                return $observation->getEseSeqno()->getDescription();
            },
            'webCommentsEn' => function ($observation) {
                return $observation->getWebCommentsEn();
            },
            'webCommentsNl' => function ($observation) {
                return $observation->getWebCommentsFr();
            },
            'webCommentsFr' => function ($observation) {
                return $observation->getWebCommentsNl();
            },


        );
    }
}