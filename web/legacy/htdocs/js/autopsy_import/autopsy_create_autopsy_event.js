$(document).ready(function(){
	
	$('#autopsy_time_flow').mask("29:59?");
	
	$('#today').click(function(){
		
		today = new Date();
		
		month = today.getMonth();
		day = today.getDate();
		year = today.getFullYear();
		
		$($(this).parent().find('select.day_date option').get(day+1)).attr("selected","selected").siblings().removeAttr("selected");
		$($(this).parent().find('select.month_date option').get(month+1)).attr("selected","selected").siblings().removeAttr("selected");
		$(this).parent().find('select.year_date option[value='+year+']').attr("selected","selected").siblings().removeAttr("selected");
		return false;
	});
});