$(document).ready(function(){
	/*
	Autocomplete Persons
	
	*/
	name_persons = $.evalJSON($('.hidden_persons').html());
	
	$("#Person_flow").autocomplete(name_persons, 
	{
		minChars: 0,
		width: 195,
		max:name_persons.length,
		mustMatch:true,
		autoFill: true,
		formatItem: function(row, i, max) {
			return  "[" + row.LAST_NAME + "]"+"[" + row.FIRST_NAME + "]";
		},
		formatMatch: function(row, i, max) {
			return  row.LAST_NAME;
		},
		formatResult: function(row) {
			return row.LAST_NAME;
		}
	});
	$('#Person_flow').result(function(event, data, formatted) 
							{ 
								if(typeof data !='undefined') {$('#Person_flow').attr('pk',data.SEQNO);}
								else{$('#Person_flow').removeAttr('pk'); }

							});
	
	/*
	Autocomplete Institutes
	
	*/						
	name_institutes = $.evalJSON($('.hidden_institutes').html());
	$("#Institute_flow").autocomplete(name_institutes, 
	{
		minChars: 0,
		width: 195,
		max:name_institutes.length,
		mustMatch:true,
		autoFill: true,
		formatItem: function(row, i, max) {
			return  "[" + row.CODE + "]"+"[" + row.NAME + "]";
		},
		formatMatch: function(row, i, max) {
			return  row.NAME;
		},
		formatResult: function(row) {
			return row.NAME;
		}
	});
	$('#Institute_flow').result(function(event, data, formatted) 
							{ 
								if(typeof data !='undefined') {$('#Institute_flow').attr('pk',data.PSN_SEQNO);}
								else{$('#Institute_flow').removeAttr('pk'); }
							});						
	
	/*
	Autocomplete Platforms
	
	*/						
	name_platforms = $.evalJSON($('.hidden_platforms').html());
	
	$("#Platform_flow").autocomplete(name_platforms, 
	{
		minChars: 0,
		width: 195,
		max:name_platforms.length,
		autoFill: false,
		formatItem: function(row, i, max) {
			return  "[" + row.NAME + "]";
		},
		formatMatch: function(row, i, max) {
			return row.SEQNO + " " + row.NAME;
		},
		formatResult: function(row) {
			return row.NAME;
		}
	});
	$('#Platform_flow').result(function(event, data, formatted) 
							{ 
								
								if(typeof data !='undefined') {$('#Platform_flow').attr('pk',data.SEQNO);}
							});		
    /*
     Permit to add multiple institutes or Persons to an observation
    
    */
		$('button.addtab').click(function(){

		if($(this).hasClass('institutes_opt'))
		{
			input_value = $(this).parents('div.qfelement:first').find('input').val();
			input_pk  = $(this).parents('div.qfelement:first').find('input').attr('pk');
			
			// check if element not already inserted
	
			if($('#institutes_opt option[pk='+input_pk+']').length == 0 && typeof input_pk !='undefined')
			{
			$('#institutes_opt').append('<option  pk='+input_pk+'>'+input_value+'</option>');
			$('#institutes_opt').parents('div:first').append('<input name="institute_opt[]" style="display:none;" value="'+input_pk+'"/>');
			}
		}
		else if ($(this).hasClass('persons_opt'))
		{
			input_value = $(this).parents('div.qfelement:first').find('input').val();
			input_pk  = $(this).parents('div.qfelement:first').find('input').attr('pk');
			
			if($('#persons_opt option[pk='+input_pk+']').length == 0 && typeof input_pk !='undefined')
			{
			$('#persons_opt').append('<option  pk='+input_pk+'>'+input_value+'</option>');
			$('#persons_opt').parents('div:first').append('<input name="person_opt[]" style="display:none;" value="'+input_pk+'"/>');
			}
		}
		
	});
	
	// delete item if existing
	$('#multiselect_contact').click(function(e){
		if(e.target.tagName == 'OPTION')
		{
			if(typeof $(e.target).attr('pk') !='undefined')
			{
				$('input[value='+$(e.target).attr('pk')+']').remove();
			}
			$(e.target).remove();
			
		}
		
	});

}); // DOCUMENT READY 
