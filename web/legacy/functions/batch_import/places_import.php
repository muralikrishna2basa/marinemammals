<?php
require_once('../../classes/db/Oracle_class.php');
$db = new ORACLE('BIOLIB_OWNER','BIOLIB123','BIOLIBD.mumm.ac.be');


if (($handle = fopen("stations.csv", "r")) !== false) 
{
    while (($data = fgetcsv($handle, 1000, ",")) !== false) 
    {
   
    $seqno = $data[0];
    $place_type = $data[2];
    $name = str_replace('\'',' ',$data[3]);
    $seqno_ref = $data[4];    
    
    $sql = "insert into places(seqno,pce_seqno,name,type) values ($seqno,$seqno_ref, '$name','$place_type')";
    $db->query($sql);
    
    if($db->iserror){ echo "error SQL: $sql <br>";return;}
    
    }
    fclose($handle);
}
?>