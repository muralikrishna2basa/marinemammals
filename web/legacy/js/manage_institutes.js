$().ready(function(){
	
	/* Search functionnality */
	
	callback = function()
    {
    	
    }
    
    options1 = { 
    			search_object :"Search_Institutes",
    		    perform_search:"functions/institutes_search.php",
    		    callback_results:callback,
    		    search_results:"institutes_results"
    		  };
    	
 	 $("div#search_institutes").search(options1); 
	 
	 cms({tableid:'search_institutes',classname:'Institute',formid:'Institute_form'});
	 
});