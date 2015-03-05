<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 2/03/15
 * Time: 17:08
 */

namespace AppBundle\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ObservationEditTest extends WebTestCase{

    private $em;
    private $repo;
    private $client;

    public function setUp() {
        $kernel = static::createKernel();
        $kernel->boot();
        $this->em = $kernel
            ->getContainer()
            ->get('doctrine.orm.entity_manager');

        $this->em->beginTransaction();
        $this->client = static::createClient();
    }

    public function testEditUrl()
    {
        $this->setUp();
        $this->repo=$this->em->getRepository('AppBundle:Observations');
        $observations = $this->repo->getCompleteObservation();

        foreach ($observations as $o){

            $i=$o->getEseSeqno()->getSeqno();
            // Create a new entry in the database
            $url='http://127.0.0.1:8000/observations/update/'.$i;
            $crawler = $this->client->request('GET', $url);
            //fwrite(STDERR, $url."\n");
            $statusCode=$this->client->getResponse()->getStatusCode();
            if($statusCode != 200){
                fwrite(STDERR, $url.":".$statusCode."\n");
            }

           // $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /user/");
           // fwrite(STDERR, $url.': '.$statusCode);


        }
    }
}