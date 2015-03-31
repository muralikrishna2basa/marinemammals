$().ready(function(){
	$('form.upload_form[class=autopsy_flow]  button.add').click(function(){
		input = $('form.upload_form[class=autopsy_flow] div.upload_form div.initinput').html();
		$('form.upload_form[class=autopsy_flow] div#inputs').append(input);
		return false;
	});
	$('form.upload_form[class=autopsy_flow] div#inputs').click(function(e){
		if($(e.target).attr('class')=='del')
		{
			$(e.target).parent().remove();
		}
		
	});
	$('form.upload_form[class=autopsy_flow] div.block button.del').click(function(){
		
		$(this).parents('div.block:first').remove();
		return false;
	});
	
	$('form.upload_form[class=autopsy_flow] input.img_select').change(function(){
		if($(this).is(':checked')){ value = '1';}
		else
		{ value = '0';}
		$(this).parent().find('input.checksave').val(value);
	});
});