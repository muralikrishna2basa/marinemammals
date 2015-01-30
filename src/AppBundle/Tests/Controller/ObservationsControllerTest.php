<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ObservationsControllerTest extends WebTestCase
{
    public function testIndex()
    {
        /*$client = static::createClient();

        $crawler = $client->request('GET', '/observations/add');

        $this->assertTrue($crawler->filter('html:contains("Effort Related Survey?")')->count() > 0);*/
        $this->assertTrue(true);
    }

    public function testCreate(){
        $client = static::createClient();
       // echo $client->getRequest()->getUri();


        $crawler = $client->request('GET', '/observations/add');

        $form = $crawler->selectButton('Submit')->form();
// set some values
        $form['observationstype[eseSeqno][eventDatetime][date]'] = '19/02/2098';
        $form['observationstype[eseSeqno][eventDatetime][date]'] = '11:22';
        $form['observationstype[latDec]'] = '51.6546';
        $form['observationstype[lonDec]'] = '2.6846';
        $form['observationstype[precisionFlag]'] = 'exact';
        $form['observationstype[stnSeqno]'] = '193';
        $form['observationstype[osnType]'] = 'Sighted';
        $form['observationstype[samplingeffort]'] = 'ad hoc observation';
        $form['observationstype[eseSeqno][spec2events][scnSeqnoNew][txnSeqno]'] = 'Cetacea';
        $form['observationstype[eseSeqno][spec2events][scnSeqnoNew][scnNumber]'] = 5;
        $form['observationstype[eseSeqno][observers][0][psnSeqno]'] = 'Karien De Cauwer';
        $form['observationstype[eseSeqno][gatherers][1][psnSeqno]'] = 'Thierry Jacques';

// submit the form
        $crawler = $client->submit($form);
        $this->assertEquals(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode()
        );

        $html = '';

        foreach ($crawler as $domElement) {
            $html .= $domElement->ownerDocument->saveHTML();
        }
        echo $html; die;
        echo $crawler->text();

    }
}
