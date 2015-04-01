$().ready(function(){
	
	// init value at load time
	$('#autopsy_importation_tool div.container_action form input.thread').val('init');
	
	callbackautopsies = function()
	{
		
			$('#search_for_autopsies div.autopsy_results tr').click(function(){
			
			if( $(this).attr('pk') == undefined){ return false;} // because the evalJSON need to have a valid input otherwise it triggers an error
						
			test = $.evalJSON($(this).attr('pk'));
			
			if(typeof test != 'undefined') 
			{
			pk = test.Seqno;
			$('#autopsy_importation_tool div.container_action form input.thread').val(pk);
			$('#autopsy_importation_tool div.container_action button.next').click(); // simulate a click on next 

			}
		});
		
	}
	
		 options_autopsies = { 
    			search_object :"Search_Necropsy",
    		    perform_search:"/legacy/functions/necropsies_search.php",
    		    search_results:"autopsy_results",
    		    callback_results:callbackautopsies
    		  };
    $("div#search_autopsies").search(options_autopsies);
    

	 
	 
});	