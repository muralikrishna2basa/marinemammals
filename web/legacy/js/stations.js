$(document).ready(function(){
	
		
	var initbuttons = function()
	{
		$('#station_tool button').css('visibility','hidden');
	}
	var addbuttons = function()
	{
		$('#station_tool button[class*="add"]').css('visibility','visible');
		$('#station_tool button[class*="update"],#station_tool button[class*="delete"]').css('visibility','hidden');
	}
	var updatebuttons = function()
	{			
		$('#station_tool button[class*="update"],#station_tool button[class*="delete"]').css('visibility','visible');
		$('#station_tool button[class*="add"]').css('visibility','hidden');
	}
	
	var getPlaceJson = function()
	{
		var datatosend = {};
		
		$('#obplaces select').each(function(){
			
			selected = $(this).find('option:selected');
			count = 0;
			
			if(selected.length != 0)
			{
					name = $(this).attr('name');
					value = selected.html();
					count++;
					datatosend[name]= value;
				
				
			}
		});
		
		return $.toJSON(datatosend);
	}
	// at document load, load the corresponding items in first select
	var getStationDetails = function(event)
	{
		seqno_choice = $(this).find('option:selected').attr('value');
		
		// display or not the add, update, delete functionality based on its value

		if(seqno_choice!='init' && seqno_choice!='toadd')
		{
			$.ajax({
				data:{'seqno':seqno_choice},
	  			datatype:'json',
	  			type: 'POST',
				url:'functions/remote.php',
				success:function(data)
				{
					data_station = $.evalJSON(data);
					html_station = data_station.html;
					$('div.station_items').html(html_station);
					
	                updatebuttons();
	               $('#station_latitude').mask("99/99?/99");
	               $('#station_longitude').mask("99/99?/99");
				}
			});
		}
		else if(seqno_choice=='init') // hide update,add, delete functionalities
		{
			
			initbuttons();
		}
		else // toAdd selected
		{  
			 addbuttons();
		}
	}

	$('#station_detail div.station_choice select').change(getStationDetails);
	
	var populate = function(event)
	{
		
		 // When there is a change in the place  
		 initbuttons();
		 $('div.errormessage').html("");	
		 
    	 index = $('#obplaces select').index($(event.target));
         
         $("#obplaces select:gt("+index+")").empty();
		


		 	datasend = {'datatosend':getPlaceJson()};
		
		
			$.ajax({
				data:datasend,
	  			datatype:'json',
	  			type: 'POST',
				url:'functions/remote.php',
				success:function(data)
				{
					data_object = $.evalJSON(data);
					html = data_object.html;
			
					
					level = data_object.level;
					
					var station = data_object.station;
				
					var isstation = data_object.isstation;
				
					if(isstation == 'true')
					{
						$('div.hasstation img.ok').show().siblings().hide();
					}
					else
					{
						$('div.hasstation img.ok').hide().siblings().show();
					}
					
					$('#station_detail div.station_choice select').html(station);
					
					select = $('#obplaces select')[level];
					
					$(select).append(html);

					
				}
			});
	}		
			
	$('#obplaces select').change(populate);
	
	// Update, Add, Delete optionalities

	$('#station_tool select.area_type').change(function(){
		
		selected_station_tool = $(this).find(':selected');
		
		selected_element = selected_station_tool.html();

		if(typeof(selected_element) == 'string' && selected_element  !='Choose'){ // select only if item not blanck
			
			option_station_choice = $('#station_detail div.station_choice select:first').find(':selected');
			
			opval_station_choice = option_station_choice.val();
	
			if(typeof(opval_station_choice) == 'string' && opval_station_choice == 'init')  // In case no station is already set
			{
				stationalreadyexist = 'false';
				// check that a station with the corresponding area type doesn't already exists  
				$('#station_detail div.station_choice select:first option').each(function()
				{
					 if($(this).html() == selected_element){ stationalreadyexist = 'true';}
				});
				if(stationalreadyexist == 'true')
				{
					$('div.errormessage').html('station already exists or in process to be created'); 
					return; 
				}
				// check that the first value item on place is not null
				
				option_level0 = $('#obplaces select.level0 option:selected');
				opval_level0 = option_level0.val();
				
				if(typeof(opval_level0) == 'string'&& opval_level0 == 'init')
				{
					$('div.errormessage').html("doesn't correspond to a station"); return;
				} 

			   option_station_choice.after('<option value="toadd">'+selected_element+'</option>');
			   option_station_choice.next().attr('selected','selected').siblings().removeAttr('selected');
				option_station_choice.change();
		//	   selected_station_tool.change(); // simulate a change so that update & add functionnalities might be added
			}
			else // In case a station is already set
			{
				option_station_choice.html(selected_element);
	        	option_station_choice.change();
			}
			$('div.errormessage').html("");
		}
		else
		{
			$('div.errormessage').html("");
		}
		
	});
	// bind a trigger to the add, update, delete functions
	 $('#station_tool button.station_manage').click(function(){ 
	 	 
	  		action = $(this).val();
	  		
	  		station_value = $('#station_detail div.station_choice select:first option:selected').val(); // number,init or toadd
	  		
	  		place_seqno = $('#obplaces select option:selected[value!="init"]:last').val();
	  		
	  		//alert(place_seqno);
	  		
	  		//return false;
	  		
	  		datastation_manage = {'place':place_seqno,
	  		            'action':action,
	  		            'station_latitude':$('#station_latitude').val(),
	  		            'station_longitude':$('#station_longitude').val(),
	  		            'station_code':$('#station_code').val(),
	  		            'station_description':$('#station_description').val(),
	  		            'station_area_type':$('#station_detail div.station_choice select:first option:selected').html(),
	  		            'station':station_value
	  		            };

	  		$.ajax({
				data:datastation_manage,
	  			datatype:'json',
	  			type: 'POST',
				url:'functions/remote.php',
				success:function(data)
				{
					data_object = $.evalJSON(data);

					isError = data_object.isError;
					if(isError == 'true' || isError == 'false')
					{
						$('div.errormessage').html(data_object.errormessage);
					}
				}
			});                
	  		            
	  		
	  		return false; // prevent form submission
	          	
	 });
	 
	 
	 
	 // use the mask input function 
	 	$('#station_latitude').mask("99/99?/99");
	    $('#station_longitude').mask("99/99?/99");
	
});
