<?php
namespace AppBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class DateTimeToDateTimeArrayTransformer implements DataTransformerInterface
{
    public function transform($datetime)
    {
        if(null !== $datetime)
        {
            $date = clone $datetime;
            $ti=new \DateInterval('P1D');
            $date=$date->add($ti);
            $date->setTime(0, 0, 0);

            $time = clone $datetime;

            $ti=new \DateInterval('PT1H');
            $time=$time->add($ti);
            $time->setDate(1970, 1, 1);
            //$date=$datetime->format("H:i");
        }
        else
        {
            $date = null;
            $time = null;
        }

        $result = array(
            'date' => $date,
            'time' => $time
        );

        return $result;
    }

    public function reverseTransform($array)
    {
        $date = $array['date'];
        $time = $array['time'];

        if(null == $date || null == $time)
            return null;
        $date->setTimezone(new \DateTimeZone('Europe/Paris'));
        $date->setTime($time->format('G'), $time->format('i'));

        return $date;
    }
}