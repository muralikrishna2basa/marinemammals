$().ready(function(){
$('#LOGIN_NAME-0').change(function(){
	   that = $(this);
	   var input = $(this).val();
	    that.parents('div:first').removeClass('error');
	    that.parents('div:first').find('span,br').remove();
		$.ajax({
			     url: 'functions/Checklogin2.php',
			     type:'POST',
			     datatype: 'json',
			     data: 'login='+input,
		         success:function(data){
		         	   error = $.evalJSON(data).error;
                       content = $.evalJSON(data).content;
                     
                       if(error.error_bool){
                             $('div.footer_error').append(error.error_message).css('visibility','visible');
                                     return;};

						if(content == false ) { return;} 
						else { 
							that.parents('div:first').addClass('error');
							that.parents('div:first').prepend('<span class="error">Login taken</span>');
						
						} 
		         		         	 					} // SUCCESS
					});		
	
});
	$('#Phone_Number-0,#PHONE_NUMBER-0').mask("(9999)?999-9999999");

});