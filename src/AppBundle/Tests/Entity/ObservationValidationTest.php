<?php
namespace AppBundle\Tests\Entity;


require_once 'PHPUnit/Autoload.php';

class ObservationValidationTest extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{

    private function validateAndPrint($o){
        $client = static::createClient();
        $validator = $client->getContainer()->get('validator');

        //$validator = Validation::createValidatorBuilder()->getValidator();

        $errors = $validator->validate($o);
        fwrite(STDERR, "Object ".get_class($o)."\n\n");
        if (count($errors) > 0) {
            //$errorsString = (string) $errors->getMessage();
            foreach ($errors as $e){
                fwrite(STDERR, 'property: '.print_r($e->getPropertyPath(), TRUE).'; ');
                fwrite(STDERR, 'message: '.print_r($e->getMessage(), TRUE).'; ');
                fwrite(STDERR, 'value: '.print_r($e->getInvalidValue(), TRUE).PHP_EOL);
            }
        }
        else {fwrite(STDERR, "Valid object \n\n");
        }
        fwrite(STDERR, '--------------------------'.PHP_EOL);
        return $errors;
    }

    private function assert($o){
        $errors=$this->validateAndPrint($o);
        $this->assertEquals(0, count($errors));
    }

    public function testObservationValidation()
    {
        $o=new \AppBundle\Entity\Observations();
        $e=new \AppBundle\Entity\EventStates();
        $s2e=new \AppBundle\Entity\Spec2Events();
        $s=new \AppBundle\Entity\Specimens();
        $sv=new \AppBundle\Entity\SpecimenValues();
        $pm=new \AppBundle\Entity\ParameterMethods();


        $sv->setS2eScnSeqno($s2e);
        $sv->setPmdSeqno($pm);
        $sv->setValue("Slight decoloration of the ...");
        $s->setScnNumber(1);
        $s->setSex('UNK');
        $s->setNecropsyTag('BE-1996-65465');
        $s->setIdentificationCertainty(false);
        $e->setSpec2Events($s2e);
        $s2e->setScnSeqno($s);
        if($s->isScnNumberLegal()){
            fwrite(STDERR, "specimen number legal (no measurements): true \n\n");
        }
        else{
            fwrite(STDERR, "specimen number legal (no measurements): false \n\n");
        }
        $e->setEventDatetime(new \Datetime('1999-05-28'));

        fwrite(STDERR, $s2e->getEseSeqno()->getDate()."\n\n");
        fwrite(STDERR, $e->getSpec2Events()->getEseSeqno()->getDate()."\n\n");
        fwrite(STDERR, $s->getSpec2Events()->first()->getEseSeqno()->getDate()."\n\n");
        fwrite(STDERR, $s->getSpec2Events()->first()->getValues()->first()->getValue()."\n\n");
        $e->setEventDatetimeFlag('1');
        $o->setEseSeqno($e);
        $o->setlatDec(26.65465);
        $o->setlonDec(2.6546);
        $o->setIsconfidential(false);
        $o->setOsnType('FDB');
        $o->setPrecisionFlag('1');
        $o->setSamplingeffort('2');
        $o->setCpnCode('CP-64654-6466');
        $o->setWebcommentsEn('zrrrrrrrrgv');
        $this->assert($o);
        $this->assert($e);
        $this->assert($s2e);
        $this->assert($s);
    }

   /* public function testObservation2Validation()
    {
        $o=new \AppBundle\Entity\Observations();
        $o->setlatDec(29.65465);
        $o->setlonDec(1.654);
        $o->setIsconfidential(true);
        $o->setOsnType('FDB');
        $o->setPrecisionFlag('exactORprecise');
        $o->setSamplingeffort('Three goddamn days in the mud');
        $this->assert($o);
    }*/
}