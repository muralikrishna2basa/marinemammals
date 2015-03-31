$(document).ready(function(){
	
	var getorganfunction = function(e){
		
		organ_code = $(e.target).val();
		
		actualorgan = $(e.target).find('option.selected').val();
		
		$(e.target).addClass('targeted');
		
	  	$.ajax({
	  			data:{'organselect':organ_code,'actualorgan':actualorgan},
	  			datatype:'json',
				url:'functions/loadorgans.php',
				success:function(data)
				{
					
				   $('.targeted').parent().addClass('targeted').html(data);
				   $('.targeted select.organ').change(getorganfunction);
				   $('.targeted').removeClass('targeted'); 
				}
	  		});
			
		
	};
	
	$('.organ_select select.organ').change(getorganfunction);
	
});