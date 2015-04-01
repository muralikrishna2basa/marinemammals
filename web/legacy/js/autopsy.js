$(document).ready(function(){

	var handlein = function()
			{
            href_pic = $(this).attr('href').substr(1);
		    
	        $('#Layout_content span[id='+href_pic+']').addClass('imgfocus');
			return false;
			}
			
	var handleout = function()
			{
			$('#Layout_content span.imgfocus').removeClass('imgfocus');		
			
			return false;
			}	
   $('div.pictures_box a').hover(handlein,handleout);
   $('div.pictures_box a').click(function(){return false;});
   
});

$(document).ready(function(){

	var handlein = function()
			{
            href_pic = $(this).attr('href').substr(1);
		    
	        $('#Layout_content span[id='+href_pic+']').addClass('imgfocus');
			return false;
			}
			
	var handleout = function()
			{
			$('#Layout_content span.imgfocus').removeClass('imgfocus');		
			
			return false;
			}	
   $('div.large_pictures_box a').hover(handlein,handleout);
   $('div.large_pictures_box a').click(function(){return false;});
   
   $('#Layout_content a.slimbox').click(function(){ $(this).siblings().click();}) // 
   
});