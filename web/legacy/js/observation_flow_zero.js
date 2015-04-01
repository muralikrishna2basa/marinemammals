$().ready(function(){
	
	// init value at load time
	$('#observation_importation_tool div.container_action form input.thread').val('init');
	
	callbackobservations = function()
	{
		
			$('#search_for_observation div.observations_results tr').click(function(){
			
			test = $.evalJSON($(this).attr('pk'));
			
			if(typeof test != 'undefined') 
			{
			pk = test.Seqno;
			$('#observation_importation_tool div.container_action form input.thread').val(pk);
			$('#observation_importation_tool div.container_action button.next').click(); // simulate a click on next 

			}
		});
		
	}
	
		 options1 = { 
    			search_object :"Search_Observations",
    		    perform_search:"functions/observations_search.php",
    		    search_results:"observations_results",
    		    callback_results:callbackobservations
    		  };
    $("div#search_observations").search(options1);
    
    
  //  $("#observation_importation_tool form:first").flow_call({target:'#observation_importation_tool div.container_action'});
	 
	 
});	