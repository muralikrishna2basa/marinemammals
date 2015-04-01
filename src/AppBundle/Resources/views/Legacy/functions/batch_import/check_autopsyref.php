<?php

echo "<input type='checkbox' checked value = '3' name = 'test'></input>";

/*  Store List of observations for which an autopsy is performed but where no autopsy reference is specified */

$fp_autopsy_ref = fopen('autopsy_ref.csv', 'w');

$conn =  odbc_connect('zeezoogdieren','','');

$sql = "select * from observations";
$rs = odbc_exec($conn,$sql);
$row = odbc_fetch_array($rs);
if (!$rs){exit("Error in SQL");}
while($row = odbc_fetch_array($rs)) 
{
	if($row['AutopsyIndicator'] == 1 && $row['AutopsyReference'] == null)
	{
		fputcsv($fp_autopsy_ref, split(',', $row['ID']));
	} 
}
fclose($fp_autopsy_ref);

?>