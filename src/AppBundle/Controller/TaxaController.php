<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TaxaController extends Controller
{

    public function newAction()
    {
        $cp = new ControllerFormSuccessPlugin($this, 'AppBundle\Entity\Taxa', null, 'taxatype', null, 'AppBundle:Taxa', null, 'AppBundle:Page:add-taxa.html.twig');
        return $cp->createEntitiesAndRenderForm('na');
    }

    public function createAction(Request $request)
    {
        $cp = new ControllerFormSuccessPlugin($this, 'AppBundle\Entity\Taxa', null, 'taxatype', null, 'AppBundle:Taxa', null, 'AppBundle:Page:add-taxa.html.twig');

        $a = $cp->createEntitiesFormsAndLists();

        $taxon = $a['entity1'];
        $taxa = $a['entity1List'];
        $form = $a['form1'];

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()
                ->getManager();
            $em->persist($taxon);
            $em->flush();

            return $cp->createEntitiesAndRenderForm('true');
        }
        return $cp->renderForm($form, $taxa, 'false');
    }

    private $repo;

    public function viewAction($id)
    {
        $this->repo = $this->getDoctrine()->getManager()->getRepository('AppBundle:Taxa');
        $taxon = $this->repo->find($id);
        if (!$taxon) {
            throw new NotFoundHttpException(sprintf('The taxon with seqno %s does not exist.', $id));
        }

        $filter = array(
            'country' => 'BE',
            'eventDatetimeStart' => null,
            'eventDatetimeStop' => null,
            'osnTypeRef' => null,
            'stationstype' => null,
            'generalPlace' => null,
            'place' => null,
            'stnSeqno' => null,
            'txnSeqno' => $taxon,
            'excludeConfidential' => true);
        $observations = $this->get('observations_provider')->loadObservationsByFilter($filter, true);
        $observations = $this->get('observations_provider')->paginate($observations);

        return $this->render('AppBundle:Page:view-taxon.html.twig', array(
            'taxon' => $taxon,
            'entities'=>$observations
        ));
    }

    public function mgmtViewAction($id)
    {
        $this->repo = $this->getDoctrine()->getManager()->getRepository('AppBundle:Taxa');
        $taxon = $this->repo->find($id);
        if (!$taxon) {
            throw new NotFoundHttpException(sprintf('The taxon with seqno %s does not exist.', $id));
        }

        $filter = array(
            //'country' => 'BE',
            'eventDatetimeStart' => null,
            'eventDatetimeStop' => null,
            'osnTypeRef' => null,
            'stationstype' => null,
            'generalPlace' => null,
            'place' => null,
            'stnSeqno' => null,
            'txnSeqno' => $taxon,
            'excludeConfidential' => false);
        $observations = $this->get('observations_provider')->loadObservationsByFilter($filter, false);
        $observations = $this->get('observations_provider')->paginate($observations);

        return $this->render('AppBundle:Page:view-taxon.html.twig', array(
            'taxon' => $taxon,
            'entities'=>$observations
        ));
    }


}
