<?php
/**
 * 	Check persons integrity. 
 * 
 */

// Access databae
$dbAc =  odbc_connect('zeezoogdieren','','');

// Retrieve id's from persons and observations table

$sql = "select * from Persons";
$rsPersons = odbc_exec($dbAc,$sql);
if(!$rsPersons){ exit('Error in sql');}
$persons = array();
while($row = odbc_fetch_array($rsPersons ) )
{
	$persons[] = $row['ID'];
}

$sql = "select * from Observations";
$rsObservations = odbc_exec($dbAc,$sql);
if(!$rsObservations){ exit('Error in sql');}
$observations = array();
while($row = odbc_fetch_array($rsObservations ) )
{
	$observations[] = $row['ID'];
}
// Check consistency table ObservationsGatheredBy
$sql = "select * from ObservationsGatheredBy";
$rscheck1 = odbc_exec($dbAc,$sql);
if(!$rscheck1){ exit('Error in sql');}

echo "----------------------------------<br>";
echo "TABLE ObservationsGatheredBy<br>";
echo "----------------------------------<br>";

while($row = odbc_fetch_array($rscheck1 ) )
{
	if(!in_array($row['ObservationID'],$observations) || !in_array($row['GathererID'],$persons))
	{
		if(!in_array($row['ObservationID'],$observations)){echo "ObservationID ".$row['ObservationID'].'<br>';}
		else {echo "GathererID ".$row['GathererID'].'<br>';}
		
	}
}


// Check consistency table ObservationInformers
$sql = "select * from ObservationInformers";
$rscheck2 = odbc_exec($dbAc,$sql);
if(!$rscheck2){ exit('Error in sql');}

echo "----------------------------------<br>";
echo "TABLE ObservationInformers<br>";
echo "----------------------------------<br>";
while($row = odbc_fetch_array($rscheck2 ) )
{
	if(!in_array($row['ObservationID'],$observations) || !in_array($row['InformerID'],$persons))
	{
		if(!in_array($row['ObservationID'],$observations)){echo "ObservationID ".$row['ObservationID'].'<br>';}
		else {echo "InformerID ".$row['InformerID'].'<br>';}
	}
}
?>