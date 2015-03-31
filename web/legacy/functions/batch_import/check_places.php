<?php
/**
 * 	Check Access Places table consistency
 * 
 */

// Access databae
$dbAc =  odbc_connect('zeezoogdieren','','');


$sql = "select * from observations";
$rsAc = odbc_exec($dbAc,$sql);

if(!$rsAc){ exit('Error in sql');}


$sql = "select Place from places";
$rsPlaces = odbc_exec($dbAc,$sql);
$place = array();
while($row = odbc_fetch_array($rsAc ) )
{
	$place[] = $row['Place'];
}

$test = in_array('Ostend Pelagic',$place);

$counter = 0;
while($row = odbc_fetch_array($rsPlaces )) // foreach observation 
{

//	if($row['Place']=='Ostend Pelagic'){echo "yes<br>";}
	
if(!in_array($row['Place'],$place))
{
	$counter++;
	echo $row['Place'].'<br>';
}
//{
//	$place_insert = $row['Place'];
//	$country = $row['Country'];

	//	$sql = "insert into places (Place,Country) values ('$place_insert','$country')";
//	$results = odbc_exec($dbAc,$sql);
//	echo $row["Place"]."<br>";
//	$counter++;
		
}	




echo "$counter Wrongly identified places";
?>