<?php
// src/AppBundle/Controller/PageController.php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{

    public function indexAction()
    {
        $filter['excludeConfidential']=true;
        $filter['country']='BE';
        $filter['topNLatest']=10;

        $observations = $this->get('observations_provider')->loadObservationsByFilter($filter,true);
        return $this->render('AppBundle:Page:index.html.twig', array(
            'observations'=>$observations
        ));
    }

    public function aboutObservationsAction()
    {
        $taxaRepo = $this->getDoctrine()->getManager()->getRepository('AppBundle:Taxa');

        $species = $taxaRepo->getAllNSTaxaWOCollectiveSpeciesQb()->getQuery()->getResult();

        usort($species, function($a, $b){
            return strCmp($a->getVernacularNameEn(), $b->getVernacularNameEn());
        });


        $collectiveSpecies = $taxaRepo->getAllNSTaxaOnlyCollectiveSpeciesQb()->getQuery()->getResult();

        usort($collectiveSpecies, function($a, $b){
            return strCmp($a->getVernacularNameEn(), $b->getVernacularNameEn());
        });

    	return $this->render('AppBundle:Page:about-observations.html.twig', array(
            'species'=>$species,
            'collectiveSpecies'=>$collectiveSpecies
        ));
    }

    public function aboutNecropsiesAction()
    {
        return $this->render('AppBundle:Page:about-necropsies.html.twig');
    }

    public function aboutBiobankAction(){
        return $this->render('AppBundle:Page:about-biobank.html.twig');
    }

}