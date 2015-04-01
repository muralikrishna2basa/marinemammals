<?php
   $filename = $_GET['filename'];
   header("Content-length: " . filesize($filename));
   header("Content-type: application/force-download");
   header("Content-Disposition: attachment; filename = ".basename($filename));
   header("Content-Transfer-Encoding: binary");
   readfile("$filename"); 

?>