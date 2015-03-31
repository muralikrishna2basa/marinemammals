$().ready(function(){
	
		callbacksamples = function()
	{
		$('div#detail_orders div.samples_order table').click(function(event){
								
							id = $(event.target).parents('tr:first').attr('pk');
							
							
						    $('div#detail_orders div.locations div').hide(); // so it supposes no other div are of interest besides the first 
						    // descendant 
							$('div#detail_orders div.locations div:first[pk='+ id + ']').show();
							});
	}
	
    
    	
	callback = function()
	{  
    	$('div#view_orders div#search_order div.search_results table tr[pk]').click(function(){
					
					// addClass isclicked to the table row, remove all siblings classes isclicked
					$(this).addClass('isclicked').siblings().removeClass('isclicked');
					
					id = $(this).attr('pk');
					
					
					
					if(!id){ return;}
					
					tmp = $.evalJSON(id);
					
					seqno = tmp['Seqno'];
					
					$('div#detail_orders div.Search div.fields select').html("<option selected='selected'>"+seqno+"</option>");
					$('div#detail_orders div.Search div.filters select').html("<option selected='selected'>Loan Seqno</option>");
					$('div#detail_orders div.Search div.tokens select').html("<option selected='selected'>=</option>");
					$('div#detail_orders div.search_tool a.Search_for').click();
							
							
				
				}); // END CLICK
    
	}
	
	
	
	    // SEARCH ORDERS 
    options = { 
    			search_object :"Search_Orders",
    		    perform_search:"functions/order_user_search.php",
    		    search_results:"search_results",
    		    callback_results:callback
    		  };	
    $("div#search_order").search(options);
    
    
	// SEARCH SAMPLES 
	options4 = { 
    			search_object :"Search_Samples",
    		    perform_search:"functions/order_user_details.php",
				search_results:"detail_orders_results",
				callback_results:callbacksamples
    		  	};	
	$("div#detail_orders").search(options4);
});