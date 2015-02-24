<?php
namespace AppBundle\Tests\Entity;


use Symfony\Component\Validator\Constraints\DateTime;

require_once 'PHPUnit/Autoload.php';

class ObservationValidationTest extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{

    private $validator;

    private function validateAndPrint($o){

        //$validator = Validation::createValidatorBuilder()->getValidator();

        $errors = $this->validator->validate($o);
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

    private function getValidator(){
        $client = static::createClient();
        $this->validator = $client->getContainer()->get('validator');
    }

    public function generateTestObject(){
        $to=array();

        $to['o']=new \AppBundle\Entity\Observations();
        $to['e']=new \AppBundle\Entity\EventStates();
        $to['s2e']=new \AppBundle\Entity\Spec2Events();
        $to['s']=new \AppBundle\Entity\Specimens();
        $to['sv']=new \AppBundle\Entity\SpecimenValues();
        $to['pm']=new \AppBundle\Entity\ParameterMethods();
        $to['t']=new \AppBundle\Entity\Taxa();

        $to['t']->setIdodId(546);
        $to['t']->setTaxonrank('species');
        $to['t']->setVernacularNameEn('Wombat');
        $to['t']->setCanonicalName('Vombatus vombo');

        $to['sv']->setvalueAssignable($to['s2e']);
        $to['sv']->setPmdSeqno($to['pm']);
        $to['sv']->setValue("Slight decoloration of the ...");
        $to['sv']->setValueFlag("euhmdrfgffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff");
        $to['s']->setScnNumber(2);
        $to['s']->setSex('UNK');
        $to['s']->setNecropsyTag('BE-1996-65465');
        $to['s']->setIdentificationCertainty(false);
        $to['s']->setTxnSeqno($to['t']);
        $to['e']->setSpec2Events($to['s2e']);
        $to['s2e']->setScnSeqno($to['s']);

        //$to['e']->setEventDatetime('1');
        $to['e']->setDate('12/03/2015');
        //$to['e']->setTime('1rth2:30hsrth');
        $dt = \DateTime::createFromFormat('d/m/Y H:i', '12/03/2015 13:3rth0');

        $to['e']->setEventDatetime($dt);
        $to['o']->setEseSeqno($to['e']);
        $to['o']->setlatDec(26.65465);
        $to['o']->setlonDec(2.6546);
        $to['o']->setIsconfidential(false);
        $to['o']->setOsnType('FDB');
        $to['o']->setPrecisionFlag('1');
        $to['o']->setSamplingeffort('2');
        $to['o']->setCpnCode('CP-64654-6466');
        $to['o']->setWebcommentsEn('zrrrrrrrrgv');

        return $to;
    }

    public function testObservationValidation()
    {
        $this->getValidator();

        $to=$this->generateTestObject();
        if($to['s']->isScnNumberLegal()){
            fwrite(STDERR, "specimen number legal (no measurements): true \n\n");
        }
        else{
            fwrite(STDERR, "specimen number legal (no measurements): false \n\n");
        }
        $to['e']->setEventDatetime(new \Datetime('1999-05-28'));

       /* fwrite(STDERR, $to['s2e']->getEseSeqno()->getDate()."\n\n");
        fwrite(STDERR, $to['e']->getSpec2Events()->getEseSeqno()->getDate()."\n\n");
        fwrite(STDERR, $to['s']->getSpec2Events()->first()->getEseSeqno()->getDate()."\n\n");
        fwrite(STDERR, $to['s']->getSpec2Events()->first()->getValues()->first()->getValue()."\n\n");*/
        $to['e']->setEventDatetimeFlag('1');
        $to['o']->setEseSeqno($to['e']);
        $to['o']->setlatDec(26.65465);
        $to['o']->setlonDec(2.6546);
        $to['o']->setIsconfidential(false);
        $to['o']->setOsnType('FDB');
        $to['o']->setPrecisionFlag('1');
        $to['o']->setSamplingeffort('2');
        $to['o']->setCpnCode('CP-64654-6466');
        $to['o']->setWebcommentsEn('zrrrrrrrrgv');

        $this->assert($to['o']);
        $this->assert($to['e']);
        $this->assert($to['s2e']);
        $this->assert($to['s']);
        $this->assert($to['sv']);
    }
}