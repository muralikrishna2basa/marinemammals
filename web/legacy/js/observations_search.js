$().ready(function(){

		 options1 = { 
    			search_object :"Search_Spec2events",
    		    perform_search:"functions/observations_search.php",
    		    search_results:"observations_results"
    		    
    		  };
    	
	 $("div#search_observations").search(options1);
	 
	
});	