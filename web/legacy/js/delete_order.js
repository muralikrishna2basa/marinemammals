$(document).ready(function(){
		
	$('#delete_order button.to_order').click(function(){
		$('div.admin_navigation a[href="#manage_orders"]').parent('li').click();
	});
});