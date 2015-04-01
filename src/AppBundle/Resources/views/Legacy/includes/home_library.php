<?php
$test  = md5('test');
/**
 *   Include File
 *   Home Library Home Menu 
 *   VERSION:1.0.0
 *   AUTHOR:De Winter Johan
 *   LAST MODIFIED USER : De Winter Johan
 *   LAST MODIFIED DATE:23/12/2009 
 */
ob_start();


require_once(Classes.'record/db_record_class.php');

$Layout->addHead(array('<link rel="stylesheet" type="text/css" href="/legacy/css/Record.css" />',
						'<link rel="stylesheet" type="text/css" href="/legacy/css/search.css" />'
						));

$auth = $Layout->getAuth();

//echo new User_record($Layout->getDatabase(),'1');

//$renderer = $test->setRenderer('table');

//$renderer->setDatas(array('class'=>'tab_output'));



echo new User_record($Layout->getDatabase(),'2');

echo new User_record($Layout->getDatabase(),'119');

//$test = new RecordsUlRenderer(array('class'=>'record_item'));
//
//$record = $test->addRecord();
//
//$text = $record->addElement('text',array('text'=>'De Winter','class'=>'textelement','name'=>'First Name'));
//
//$record = $test->addRecord();
//
//$text = $record->addElement('text',array('text'=>'Johan','class'=>'textelement','name'=>'Last Name'));
//
//$record = $test->addRecord();
//
//$text = $record->addElement('text',array('text'=>'Chauss&eacute;e D\'Alsemberg 695, 1180 Uccle','
//										 class'=>'textelement','name'=>'Address'));
//
//$record = $test->addRecord();
//
//$email = $record->addElement('email',array('name'=>'Email','mailto'=>'jdewinte@gmail.com','text'=>'jdewinte@gmail.com'));
//
//$pic = $record->addElement('pic',array('src'=>'/legacy/img/tmp_ulg_tr80.png','alt'=>'Johan Pic','class'=>array('test','boo')));


//echo $test;
?>

<?php
$tmp = ob_get_contents();
ob_end_clean();
return $tmp;
?>