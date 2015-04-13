$().ready(function(){
	test = function(tmp)
	{
		check = "";
		uncheck = "";
		$('div#manage_samples div.samples_results tbody input.sample_select').each(function(){

			if( this.checked  == true) 
			{
				if(check.length > 0)
				{
				check += ',' + $(this).parents('tr:first').attr('pk');
				}
				else
				{
				check +=  $(this).parents('tr:first').attr('pk');
				}
			}
			else 
			{
				if(uncheck.length > 0 )
				{
				uncheck += ',' + $(this).parents('tr:first').attr('pk');
			
				}
				else
				{
				uncheck +=  $(this).parents('tr:first').attr('pk');
				}
			} 
			
			
		});
		
		tmp['check'] = check;
		tmp['uncheck'] = uncheck;
		
		return tmp;
	}	
	
	
		callback = function()
    {
    	$('div#manage_samples div.samples_results input.sample_select').click(function(){
    		var tmp = $(this).parents('tr:first').children(':first').get(0);
    		
    		if(tmp.tagName == 'TH') 
    		{
    			$('div#manage_samples div.samples_results tbody input.sample_select').each(function(){
    					this.checked = !this.checked;
    			})
    		}
    		
    	});
    }
    
    options1 = { 
    			search_object :"Search_Samples",
    		    perform_search:"/legacy/functions/perform_search.php",
    		    callback_results:callback,
    		    search_results:"samples_results",
    		    datenames:['date','other date','Date Found'],
    		    callback_search:test
    		  };
    	
	 $("div#search_samples").search(options1);
	
	 
	 options2 = {
	 	search_object :"Search_Samples",
	 	perform_search:"/legacy/functions/search_order_samples.php",
	 	search_results:"search_selected_results"
	 	};
	 	
	 $("div#search_selected_samples").search(options2);
	 
	 /* ORDER TRIGGERED */
	 
	 
	$("div#order_div button.order_samples").click(function(){
		

		// IN CASE AGREEMENT FORM ALREADY PROCESSED
		if($('div#Layout_navigation ul li a[href=#agreement_biobank]:visible').size() == 1) { alert('Already an order in process');return false;}
		
		// IN CASE ORDER ALREADY IN PROCESS
		if($($('div#Layout_navigation ul li a[href=#order_samples]:visible')).size() == 1) { alert('Already an order in process');return false;}
		
		
		if($('div#search_selected_samples table').size() == 0 ){ alert('At least one sample must be selected');return false;}
		
		$('div#Layout_navigation ul li a[href=#agreement_biobank]').parent().show().click(); // simulate a click 
		
		return false;
	});

	/* AGREEMENT FORM BUTTON CLICKED */	
		
	$("div#agreement_confirmation button.order_samples").click(function(){
	
		switch($(this).attr('value').toLowerCase())
		{
		case 'agree': 
		
		$('div#Layout_navigation ul li a[href=#order_samples]').parent().show().click();
		$('div#Layout_navigation ul li a[href=#agreement_biobank]').parent().hide();
		return false;
		
		case 'disagree':
		$(this).submit();
		
		}
		
		
	});

	$("div#order_div button.add_samples").click(function(){
		$('div#search_samples div.board select.rpp').change(); // update checked elements without losing the sort and page number
		$('div#order_samples div.search_tool a.Search_for').click(); // use checked elements to display only the checked ones
		return false;
	});
	// used to update basket at load time
	$("button.add_samples").click();
	

	
});