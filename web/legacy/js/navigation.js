$(document).ready(function(){
	/*
	Navigation menus 
	*/
	
	// init 
	
	// click item
	
 	$('div#Layout_container div.main_menus li').click(function(){
 		
 		
 			current_menu = $("div#Layout_container div.main_menus ul li.isclicked a").attr('href'); // menu
 			
			navigation_clicked = $('div#Layout_navigation li.isclicked').find('a').attr('href');


 			
			$.ajax({
			url: '/legacy/functions/navigation_set.php',
			type:'POST',
			datatype: 'json',
			data: {"navigation":"{\"" + current_menu + "\":\"" + navigation_clicked + "\"}"}
			});
        
 		
 	
 	});
 	// simulate a click when a submit button is pressed inside the layout content. 
 	// 
 	$('div#Layout_content').click(function(e){ 
 		
 		// find the curent menu 
 		
 
 		
 		if(e.target.type == 'submit'){ $('div#Layout_container div.main_menus ul li.isclicked').click();}
 	});
 	
 	
	$('div#Layout_navigation').click(function(event){ 
		
		if(event.target.tagName == 'LI' || (event.target.tagName == 'A' && $(event.target).parent().attr('tagName') =='LI' )) // on click menu item
		{ 
		  
			if(event.target.tagName == 'LI')
			{
				
				$(event.target).addClass('isclicked').show().siblings().removeClass('isclicked'); // navigation
				$(event.target).parents('div:first').siblings().find('li').removeClass('isclicked');
				
				$('div#Layout_content  div'+$(event.target).find('a:first').attr('href')).show().siblings().hide();
			
			}
			else 
			{
				$(event.target).parents('li:first').show().addClass('isclicked').siblings().removeClass('isclicked'); 
				$(event.target).parents('li:first').parents('div:first').siblings().find('li').removeClass('isclicked');// navigation
			
				$('div#Layout_content  div#'+$(event.target).attr('href')).show().siblings().hide();
			
			}
		}
		else // on page load
		{	
			if($(this).find('li.isclicked').length == 0 || $(this).find('li.isclicked:hidden').length > 0 )
			{
				$(this).find('li:first').addClass('isclicked');
			}
	
			
		
		}
		return false;
	});
	 $('div#Layout_content '+'div'+$('div#Layout_navigation li.isclicked:visible').find('a:first').attr('href')).show().siblings().hide();
	
	
	
});