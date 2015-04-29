<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/03/15
 * Time: 14:17
 */

namespace AppBundle\ControllerHelper;


Class ObservationIndexArrayPropertiesSet extends GettablePropertiesSet
{
    public function __construct()
    {
        $this->functions = array(
            'location type' => function ($observation) {
                return $observation['st_areaType'];
            },
            'place' => function ($observation) {
                return $observation['p1_name'];
            },
            'location' => function ($observation) {
                return $observation['st_description'];
            },
            'decimalLatitude' => function ($observation) {
                return $observation['st_latDec'];
            },
            'decimalLongitude' => function ($observation) {
                return $observation['st_lonDec'];
            },
            'eventDate' => function ($observation) {
                return $observation['e_eventDatetime']->format("d/m/Y");
            },
            'observationType' => function ($observation) {
                return $observation['cg2_rvMeaning'];
            },
            'scientificName' => function ($observation) {
                return $observation['t_canonicalName'];
            },
            'vernacularName' => function ($observation) {
                return $observation['t_vernacularNameEn'];
            }
        );
    }
}