$(document).ready(function(){
	
	var getPlaceJson = function()
	{
		var datatosend = {};
		
		$('#obplaces_flow select').each(function(){
			
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

			$.ajax({
				data:{'seqno':seqno_choice},
	  			datatype:'json',
	  			type: 'POST',
				url:'functions/remote_stations_flow.php',
				success:function(data)
				{
					data_station = $.evalJSON(data);
					html_station = data_station.html;
					$('div.station_items_flow').html(html_station);
					
				}
			});
		

	}

	$('#station_detail_flow div.station_choice select').change(getStationDetails);
	
	var populate = function(event)
	{
		
	
		 $('div.errormessage').html("");	
		 
    	 index = $('#obplaces_flow select').index($(event.target));
         
         $("#obplaces_flow select:gt("+index+")").empty();
		


		 	datasend = {'datatosend':getPlaceJson()};
		
		
			$.ajax({
				data:datasend,
	  			datatype:'json',
	  			type: 'POST',
				url:'functions/remote_stations_flow.php',
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
					
					$('#station_detail_flow div.station_choice select').html(station);
					
					select = $('#obplaces_flow select')[level];
					
					$(select).append(html);

					
				}
			});
	}		

	if($('#station_detail_flow div.station_choice select option:selected').val()!='init')
	{
		$('div.hasstation img.ok').show().siblings().hide();
	}
   	
	$('#obplaces_flow select').change(populate);
	
	 	$('#station_latitude_freecoord').mask("99\u00B099?'99''");
	    $('#station_longitude_freecoord').mask("99\u00B099?'99''");
	    $('#time_flow').mask("29:59?");
	   
	    
});