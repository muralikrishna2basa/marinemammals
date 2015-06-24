<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 2/03/15
 * Time: 17:08
 */

namespace AppBundle\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ObservationRepoTest extends WebTestCase{

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

    public function testGetMinMax()
    {
        $this->setUp();
        $this->repo=$this->em->getRepository('AppBundle:Observations');
        $minMaxDate = $this->repo->getMinMaxDate();

        fwrite(STDERR, $minMaxDate);
           // $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /user/");
           // fwrite(STDERR, $url.': '.$statusCode);


    }
}