$(document).ready(function(){
	
	function rand ( n )
	{
  		return ( Math.floor ( Math.random ( ) * n + 1 ) );
	}
	function getimage()
	{
		image_index = rand($('#randomimage div').length -1 );
		
		dom_image = $('#randomimage div').get(image_index);
		
		$(dom_image).siblings(':visible').hide();
		$(dom_image).fadeIn(5000);
	}
	getimage();
	$(document).everyTime(10000,function() {getimage();});
});