<?php
class Toto 
{
	public $a;
	
	public function __construct($a)
	{
		$this->a = $a;
	}
}

$t = new Toto('20°C');

echo mb_detect_encoding('20°C') == false?'problem':'20°C';
echo "<br>";
echo mb_detect_encoding($t->a) == false?'problem':$t->a;

?>