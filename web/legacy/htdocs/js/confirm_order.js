$(document).ready(function(){
	
	$('input.return_date,input.rent_date').datepick({dateFormat:'dd-M-y'});
	
	
	$('#confirm_order button.to_order').click(function(){
		$('div.admin_navigation a[href="#manage_orders"]').parent('li').click();
	});
	
});