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
	
    $('div#manage_orders div#search_order div.search_results table tr[pk]').contextMenu({
					menu: 'myMenu'
				}, function(action, el) {
					
					// addClass isclicked to the table row, remove all siblings classes isclicked
					$(el).addClass('isclicked').siblings().removeClass('isclicked');
					
					id = el.attr('pk');
					
					
					
					if(!id){ return;}
					
					switch(action)
					{
					case "Details":
					
						    tmp = $.evalJSON(id);
						    seqno = tmp['Seqno'];
							$('div#detail_orders div.Search div.fields select').html("<option selected='selected'>"+seqno+"</option>");
							$('div#detail_orders div.Search div.filters select').html("<option selected='selected'>Loan Seqno</option>");
							$('div#detail_orders div.Search div.tokens select').html("<option selected='selected'>=</option>");
							
							$('div#detail_orders div.search_tool a.Search_for').click();
							
							
							
					break;
					
					case "confirm_order":case "deny_order": case "delete_order":
					
					// Prevent the user to confirm and deny the same order ( non-sense )
					if($('div#Layout_navigation ul li a[href=#delete_order]:visible,div#Layout_navigation ul li a[href=#deny_order]:visible,div#Layout_navigation ul li a[href=#confirm_order]:visible').size()>0)
					{
					alert('please, confirm or deny order first'); return false;	
					}
				 	$('div#Layout_navigation ul li a[href=#'+action+']').show().click(); // simulate a click 
					
					// append hidden input with order seqno
					$('div#Layout_content div#'+action+' form').
						prepend('<input class="rln_seqno" type="text" style = "display:none;" name="rln_seqno" value=\''+ id + '\'></input>'); 
					break;
					}

				}); // END CONTEXTMENU
    
    }
    
    // SEARCH ORDERS 
    options = { 
    			search_object :"Search_Orders",
    		    perform_search:"functions/order_search.php",
    		    callback_results:callback,
    		    search_results:"search_results",
    		    datenames:['Request Date','Return Date','Rent Date']
    		  };	
	
    $("div#search_order").search(options);
    
    
	// SEARCH SAMPLES 
	options4 = { 
    			search_object :"Search_Samples",
    		    perform_search:"functions/design_order.php",
				search_results:"detail_orders_results",
				callback_results:callbacksamples
    		  	};	
	$("div#detail_orders").search(options4);
	/*
	Context menus
	*/
	
	$('button.cancel_deny').click(function(){ 
		$('div#Layout_navigation ul li a[href=#deny_order]:visible,div#Layout_navigation ul li a[href=#delete_order]:visible,div#Layout_navigation ul li a[href=#confirm_order]:visible').hide();
		$('div#Layout_navigation ul li a[href=#manage_orders]').click();
		
	});
	
	$('button.cancel_delete').click(function(){ 
		$('div#Layout_navigation ul li a[href=#deny_order]:visible,div#Layout_navigation ul li a[href=#delete_order]:visible,div#Layout_navigation ul li a[href=#confirm_order]:visible').hide();
		$('div#Layout_navigation ul li a[href=#manage_orders]').click();
		
	});
	
});