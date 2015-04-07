//parent.window.location.reload();
$().ready(function(){


    $('button.del').click(function(){
        $(this).parents('div.photoselectionbox:first').remove();
        return false;
    });

    $('button.del_from_existing').click(function(){
        $imagediv=$(this).parents('div.button_tools:first').siblings('div.image');
        $autfileimgs=$imagediv.find("input[name*='autfileimgs']");
        $autfileimgs.val('');
        return false;
    });

	$('button.add').click(function(){
		var $input = $('div.initinput').children().clone(true,true);
		$('div#inputs').append($input);
		return false;
	});
	$('form.upload_form[class=autopsy_flow] div#inputs').click(function(e){
		if($(e.target).attr('class')=='del')
		{
			$(e.target).parent().remove();
		}
		
	});

	
	$('input.img_select').change(function(){
		if($(this).is(':checked')){ value = '1';}
		else
		{ value = '0';}
		$(this).parent().find('input.checksave').val(value);
	});
});