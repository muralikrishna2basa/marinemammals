<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title> Random Image </title>
<script type="text/javascript" src="js/jquery.1.3.2.js"></script>
<script type="text/javascript" src="js/jquery.json-1.3.js"></script>
<script type="text/javascript" src="js/jquery.timers-1.2.js"></script>
<script type="text/javascript" src="js/randomimage2.js"></script>
<link rel="stylesheet" type="text/css" href="css/randomimage.css" />
</head>
<body>
<div id='randomimage'>
<?php
$path = "img/Photo/"; // path ajax

$dir_handle = @opendir($path);

$files = array();
while(false !== ($file = readdir($dir_handle)))
{
	
	if($file == "." || $file == ".." ) {continue; }

	$fileimg = $path.$file;
	echo "<div style='display:none'><img src='$fileimg' height='150px'/></div>";
}


?>
</div>
</body>
</html>	