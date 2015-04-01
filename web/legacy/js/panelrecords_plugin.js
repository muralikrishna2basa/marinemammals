/**
Panel Records Plugin
Anchor to the specified form

**/
(function($) {
$.fn.panelrecords = function(options){
	
	  options = $.extend({
	  						that:$(this),
	  					    target:'functions/home_records.php',
	  					 }, options || {}); // replace default values by user defined 
          					
		   
       return this.each(function(){
       	
       var setpaneltriggers = function()
       {
       		
       		record_id = $(this).find('input[name=record_id]').val();
       		
       		var datapaneltosend = {};	
       		
       		datapaneltosend['record_id'] = record_id;
       		
       		$.ajax({
				data:datapaneltosend,
	  			datatype:'json',
	  			type: 'POST',
				url:options.target,
				success:function(data)
				{
					$(options.that).children().remove();
					$(options.that).html(data);
					$(options.that).find('button.panelright,button.panelleft').click(setpaneltriggers);
				}
       		});
       		
       	}
       	
       	
       	$(options.that).find('button.panelright,button.panelleft').click(setpaneltriggers);
       	
       	
       });
       
      };
 
})(jQuery);