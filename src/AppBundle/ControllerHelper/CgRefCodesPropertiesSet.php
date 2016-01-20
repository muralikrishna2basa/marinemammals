<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/03/15
 * Time: 14:17
 */

namespace AppBundle\ControllerHelper;

use AppBundle\Entity\Observations;

Class CgRefCodesPropertiesSet extends SettablePropertiesSet
{
    private $cgRefCodeList;

    private $repo;

    //getter of cg ref code followed by setter
    public function __construct($doctrine)
    {
        $this->repo = $doctrine->getRepository('AppBundle:CgRefCodes');
        $this->cgRefCodeList = $this->repo->getAll();
        $this->functions = array(
            'osnType' => function (Observations $o) {
                $o->setOsnType($this->getCgRefCodeMeaning('OSN_TYPE', $o->getOsnType()));
            },
            'samplingeffort' => function (Observations $o) {
                $o->setSamplingEffort($this->getCgRefCodeMeaning('SAMPLINGEFFORT', $o->getSamplingEffort()));
            },
            /*'e2pType' => function ($o) {
               $o->setOsnType($this->getCgRefCodeMeaning('E2P_TYPE'));
            },*/
            'pfmType' => function (Observations $o) {
                $pfm = $o->getPfmSeqno();
                if ($pfm !== null) {
                    $pfm->setPfmType($this->getCgRefCodeMeaning('PFM_TYPE', $pfm->getPfmType()));
                }
            },
            'areaType' => function (Observations $o) {
                $stn = $o->getStnSeqno();
                if (isset($stn)) {
                    $stn->setAreaType($this->getCgRefCodeMeaning('STN_AREA_TYPE', $stn->getAreaType()));
                }
            },
            'eventDatetimeFlag' => function (Observations $o) {
                $ese = $o->getEseSeqno();
                if ($ese !== null) {
                    $ese->setEventDatetimeFlag($this->getCgRefCodeMeaning('DATETIME_FLAG', $ese->getEventDatetimeFlag()));
                }
            },
            'precisionFlag' => function (Observations $o) {
                $o->setPrecisionFlag($this->getCgRefCodeMeaning('COORDINATE_FLAG', $o->getPrecisionFlag()));
            }
        );
    }

    private function getCgRefCodeMeaning($rvDomain, $rvLowValue)
    {
        $resultArr = array_filter($this->cgRefCodeList, function ($cgr) use ($rvDomain, $rvLowValue) {
            return $cgr->getRvDomain() === $rvDomain && $cgr->getRvLowValue() === $rvLowValue;
        });
        $result=reset($resultArr);
        $class='';
        if(is_object($result)){
            $class=get_class($result);
        }
        if ($result !== null && $class==='AppBundle\Entity\CgRefCodes') {
            return $result->getRvMeaning();
        }
        return $rvLowValue;
    }
}