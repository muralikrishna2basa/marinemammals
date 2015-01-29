<?php
namespace AppBundle\Tests\Entity;

class ObservationValidationTest extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{

    private function validate($o){
        $client = static::createClient();
        $validator = $client->getContainer()->get('validator');

        //$validator = Validation::createValidatorBuilder()->getValidator();

        $errors = $validator->validate($o);
        fwrite(STDERR, print_r($errors, TRUE));
        //fwrite(STDERR, print_r($o, TRUE));

        if (count($errors) > 0) {
            //$errorsString = (string) $errors->getMessage();
            foreach ($errors as $key=>$e){
                fwrite(STDERR, print_r($e->getMessage(), TRUE));
            }
            //fwrite(STDERR, print_r($errorsString, TRUE));
        }
        else {fwrite(STDERR, "Valid object \n\n");
        }
        return $errors;
    }

    public function testObservationValidation()
    {
        $o=new \AppBundle\Entity\Observations();
        $o->setlatDec(29.65465);
        $o->setlonDec(2.6546);
        $o->setIsconfidential(true);
        $o->setOsnType('FDB');
        $o->setPrecisionFlag(5);
        $o->setSamplingeffort('2');

        $errors=$this->validate($o);
        $this->assertEquals(0, count($errors));
    }

    public function testObservation2Validation()
    {
        $o=new \AppBundle\Entity\Observations();
        $o->setlatDec(29.65465);
        $o->setlonDec(1.654);
        $o->setIsconfidential(true);
        $o->setOsnType('FDB');
        $o->setPrecisionFlag('exactORprecise');
        $o->setSamplingeffort('Three goddamn days in the mud');

        $errors=$this->validate($o);

        $this->assertEquals(0, count($errors));
    }
}