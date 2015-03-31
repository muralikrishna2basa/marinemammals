$().ready(function(){
	

	 if($('form#Register_form').find('input#alter_seqno-0').val().length > 0 )
	 {
	 	$('div.footer button[type=submit]').hide();
		$('div.footer button[value=Update],div.footer button[value=Delete]').show();
		
		$('form#Register_form input#PASSWORD-0').parents('div.qfrow:first').hide();
		$('form#Register_form input#PASSWORD_cfm-0').parents('div.qfrow:first').hide();
	 }
				

	
	/* Search functionnality */
	   callback = function()
    {
    	
    }
    
    options1 = { 
    			search_object :"Search_Persons",
    		    perform_search:"functions/persons_search.php",
    		    callback_results:callback,
    		    search_results:"persons_results"
    		  };
    	
	 $("div#search_persons").search(options1); 
	 
	 /* Institute search */
	 
	 $.ajax({
	 			datatype:'json',
				url:'functions/persons_get.php',
				success:function(data){ 
				
					person = $.evalJSON(data).person;
					groups = $.evalJSON(data).groups;
					institutes = $.evalJSON(data).institutes;
				
					for(var institute_key in institutes)
					{
						$('form#Register_form select#Institute-0').append('<option value="'+ institute_key+'">'+ institutes[institute_key] +'</option>');
					}
				}
	 });
	 
	 /* Person detail functionality */
	 
	 $("div#search_persons").click(function(event){
		tblrow = $(event.target).parents('tr:first');
		
		seqno = tblrow.attr('seqno');
		$('form#Register_form input.seqno_alter').remove(); // to be submitted,  be later used to check what guy is going to be updated
		$('span.error').remove();
		if(typeof(seqno)=='string'){ 
			
			$.ajax({
				data:{'seqno':seqno},
				datatype:'json',
				url:'functions/persons_get.php',
				success:function(data){ 
				
					person = $.evalJSON(data).person;
					groups = $.evalJSON(data).groups;
					
					/* alter dom by placing everything in the form*/
					$('form#Register_form input,form#Register_form select').each(function(){
						$(this).val("");
		
						for(var key in person)
						{
							// replace is used to remove the string that appear when a submit is invoked, ...might be browser dependent
							if(key == $(this).attr('name').replace('_'," ") ) { $(this).val(person[key]);	}
						}
						if($(this).attr('name') == 'Institute') // take care of the institute case 
						{
							$(this).children().each(function(e){
								
								if($(this).text() == person['Institute']){ $(this).attr('selected','selected');} 
								else {$(this).removeAttr('selected');}
							
							});
						}
						if($(this).attr('name')=='GROUPS[]') { 
							
						    $(this).children().removeAttr('selected'); // init 
							
						    for(var key2 in groups)
							{	
								
								$(this).children().each(function(){
									
									if($(this).text() == key2){ $(this).attr('selected','selected');}
									
								});
							//	$(this).append("<option>"+ key2 + "</option>");
							}
						}
						
					});
				$('form#Register_form').find('input#alter_seqno-0').val(seqno);	
				
				}
			});
			
			$('div.footer button[type=submit]').hide();
			$('div.footer button[value=Update],div.footer button[value=Delete]').show();
			$('form#Register_form input#PASSWORD-0').parents('div.qfrow:first').hide();
			$('form#Register_form input#PASSWORD_cfm-0').parents('div.qfrow:first').hide();
		}
		else
		{
			$('form#Register_form input').val("");
			$('form#Register_form select#Sex-0').val("");
		    $('form#Register_form select#GROUPS-0').children().removeAttr('selected'); 
		   
			$('div.footer button[type=submit]').hide();
			$('div.footer button[value=Add]').show();
			$('form#Register_form input#PASSWORD-0').parents('div.qfrow:first').show();
			$('form#Register_form input#PASSWORD_cfm-0').parents('div.qfrow:first').show();
		}
	 });
	 
	 
	 	

	
	
	 
});
