<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="js/jquery.1.3.2.js"></script>
<script type="text/javascript" src="js/jquery.json-1.3.js"></script>
<script type = "text/javascript">
$().ready(function(){
$('#button').click(function(){
	  
	   var input = $('#input').val();
	   
		$.ajax({
			     url: 'functions/Checklogin2.php',
			     type:'POST',
			     datatype: 'json',
			     data: 'login='+input,
		         success:function(data){
		         	   error = $.evalJSON(data).error;
                       content = $.evalJSON(data).content;
                     
                       if(error.error_bool){
                             $('div.error_message').append(error.error_message).css('visibility','visible');
                                     return;};

						if(content == false ) { alert('false');return;} 
						else { alert('true');return;} 
		         		         	 					} // SUCCESS
					});		
	
});
});

</script> 
<title> TEST  </title>
</head>
<body>
<input id = "input"></input>
<button id = "button" type="button">BUTTON</button>
<div class ="error_message" style="visibility:hidden;"></div>
</body>
</html>

