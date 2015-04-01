$(document).ready(function(){
	
	$(document).everyTime(5000,function() {
				$.ajax({
				url:'functions/random_image_get.php',
				success:function(data)
					
				{
					$('#randomimage img').attr('src',data);
				}
				});
	});

	
});