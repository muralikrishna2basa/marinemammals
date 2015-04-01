$().ready(function(){
	
	 options1 = { 
    			search_object :"Search_Taxas",
    		    perform_search:"/legacy/functions/taxas_search.php",
    		    search_results:"taxas_results"
    		    
    		  };
    	
	 $("div#search_taxas").search(options1);
	 
	$('div#Layout_navigation').accordion({ header: 'h3','fillSpace': false,'clearStyle': true });
	   
	 
	  cms({tableid:'search_taxas',classname:'Taxa',formid:'Taxa_form'});
	  
	  $("#autopsy_importation_tool form.flow_autopsy_form").flow_call({
	  													  	target:'#autopsy_importation_tool div.container_action',
	  													    flowname:'flow_autopsy_form'
	  													  });
	  
	  $("#observation_importation_tool form.flow_observation_form").flow_call({
	  													  	target:'#observation_importation_tool div.container_action',
	  													    flowname:'flow_observation_form'
	  													  });
});