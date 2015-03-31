/**
CMS Plugin
*/
(function($) {
cms = function(options){
//	  
	  options = $.extend({ classname :'Institute',
	  					   formid :'manage_institutes',
	  					   buttondiv:'footer',
	  					   tableid:''
	          			}, options || {}); // replace default values by user defined 
	          			

	   			

	 
	  $('#' + options.tableid).click(function(e){
	  	 
	  	tblrow = $(e.target).parents('tr:first');
	  	
	  	pk = tblrow.attr('pk');
	  	
	  	if(typeof(pk)!='string'){pk = "";}
     
	  	$.ajax({
	  			data:{'pk':pk,'class':options.classname},
	  			datatype:'json',
				url:'functions/cms_load.php',
				success:function(data)
				{
					
					$('#'+options.formid).parent().append(data).find('#'+options.formid +':first').remove();
				}
	  		});
			
	  		
	  			
	  	
	  });        			
}
//	          				
//
})(jQuery);
	          				          			

