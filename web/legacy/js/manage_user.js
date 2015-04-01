$().ready(function(){
	
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
	 
	 cms({tableid:'search_persons',classname:'Person',formid:'Person_form'});
	 
	 $('#Phone_Number-0,#PHONE_NUMBER-0').mask("+999?9?/9999999999");
     	
});	 