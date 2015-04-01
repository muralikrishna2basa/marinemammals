<?php
function fixEncoding($in_str)
{  
	/*
	fix the encoding for string, keyed array
	*/ 
    if(is_string($in_str)){ $in_str = array($in_str);}
	
	$in_str_tmp = array();
	foreach($in_str as $key =>$input  )
	{	
  		$cur_encoding = mb_detect_encoding($input) ;
  		if($cur_encoding == "UTF-8" && mb_check_encoding($input,"UTF-8"))
    		$in_str_tmp[$key] =$input;
  		else
            $in_str_tmp[$key] = utf8_encode($input);
    }
    if(count($in_str_tmp)>1) { return $in_str_tmp;}
    else { return $in_str_tmp[$key];} 

}
function fixDecoding($in_str)
{
	if(is_string($in_str)){ $in_str = array($in_str);}
	if(!is_array($in_str)){ return $in_str;}
	$in_str_tmp = array();
	foreach($in_str as $key =>$input  )
	{	
  		$cur_encoding = mb_detect_encoding($input) ;
  		if($cur_encoding == "ISO-8859-1" && mb_check_encoding($input,"ISO-8859-1"))
    		$in_str_tmp[$key] =$input;
  		else
            $in_str_tmp[$key] = utf8_decode($input);
    }
    if(count($in_str_tmp)>1) { return $in_str_tmp;}
    else { return $in_str_tmp[$key];}
}
?>