$().ready(function(){
	
	/* Search functionnality */
	
	callback = function()
    {
    	
    }
    
    options1 = { 
    			search_object :"Search_Samples",
    		    perform_search:"functions/samples_search.php",
    		     callback_results:callback,
    		    search_results:"samples_results"
    		  };
     
	 $("div#search_samples").search(options1); 
	 
	 cms({tableid:'search_samples',classname:'Sample',formid:'Sample_form'});
	
});