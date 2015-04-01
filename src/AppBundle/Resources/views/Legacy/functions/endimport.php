<?php

$tmp = ob_get_contents();

ob_end_clean();
		
//$html = preg_replace("/\r?\n/", "\\n", addslashes($tmp)); 
$html = $tmp;
$html = str_replace("\'","'",$html); // don't escape quotes i.e if \' => needed '
$html = fixEncoding($html);
echo $html;

?>