$().ready(function(){
	$('form.upload_form button.add').click(function(){
		input = $('div.upload_form div.initinput').html();
		$('form.upload_form div#inputs').append(input);
		return false;
	});
	$('form.upload_form div#inputs').click(function(e){
		if($(e.target).attr('class')=='del')
		{
			$(e.target).parent().remove();
		}
		
	});
});