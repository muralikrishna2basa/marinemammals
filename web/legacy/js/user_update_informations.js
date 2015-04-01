$().ready(function(){
	$('#link_update_password').click(function(){
		
		$('#Layout_navigation').find('li a[href="#change_password"]').parent().click();
	});	

     $('#Phone_Number-0').mask("+999?9?/9999999999");
});	 