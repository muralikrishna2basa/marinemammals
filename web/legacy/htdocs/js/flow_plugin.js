/**
Flow plugin 

Anchor to the specified form

**/
(function($) {
$.fn.flow_call = function(options){
	
	  options = $.extend({
	  						that:$(this),
	  					    target:'#observation_importation_tool div.container_action',
	  					    flowname:'flow_observation'	
	                     }, options || {}); // replace default values by user defined 
          					
		   
       return this.each(function(){
       
	// mimic the submit button 
	var getFormDatas = function(form){
		
		var datatosend = {};		

	$(form).find('input,select,textarea').each(function()
	{
		if(this.tagName == 'SELECT')
		{
			selected = $(this).find('option:selected');
				
			if(selected.length != 0){	datatosend[$(this).attr('name')]= selected.val(); }
		}
		if(this.tagName == 'INPUT' || this.tagName == 'TEXTAREA')
		{
            
			name_input = this.name;
			
			if(name_input.indexOf("[]")!=-1) // take the arrays into account
			{
				if(name_input in datatosend){ datatosend[name_input].push(this.value);}
				else{	datatosend[name_input] = new Array(this.value); }
			}
			else{ datatosend[name_input]= this.value; }
		}
	
		
	});
		return datatosend;
	}
	
	
	
	var AjaxRequest = function()
	{
		$(options.target).maskload('Waiting...');
		
		form = $(this).parents('form.'+options.flowname);
	    
	 
		datatoSend = getFormDatas(form);
	    
	   
	    
	    datatoSend['button'] = $(this).attr('class');
	    
	    
	    if($(this).attr('class') == 'screen')
	    {
	    	datatoSend['screen_pos'] = $(this).attr('href');
	    }
	    
		$.ajax({
				data:datatoSend,
	  			datatype:'json',
	  			type: 'POST',
				url:'functions/flow_remote.php',
				success:function(data)
				{
					
					
				   if(data == undefined) { return false;}
				   	
				   $(options.target).html(data);
		          
				   $(options.target).unmaskload();
				   
				   css_file = $(options.target).find('#newcss').val();
				   
				   javascript = $(options.target).find('#newjs').val();
				   
				   oldjs = $(options.target).find('#oldjs').val();
				   
				   oldcss = $(options.target).find('#oldcss').val();
				   
				 //  alert(data);
				   
				  // data_flow = $.evalJSON(data);
				   
				  //alert('json correctly evaluated');
				   
//				   html_flow = data_flow.html;
//				   
//				   container = data_flow.action;
				   
				//   javascript = data_flow.js;
				   
//				   css_file = data_flow.css;
//				   
//				   oldjs = data_flow.oldjs;
//
//				   oldcss = data_flow.oldcss;
				   
				   oldcssDom = $('head link[href="'+oldcss+'"]');
				   
				   oldjsDom = $('head script[src="'+oldjs+'"]');
				  
				   if(oldcssDom.length != 0) { oldcssDom.remove();}
				   if(oldjsDom.length != 0){ oldjsDom.remove();}
				   
			      if(typeof(css_file)!='undefined' && $('link[href='+css_file+']').length == 0)
		           {
		           	
		           	var fileref=document.createElement("link");
 					 fileref.setAttribute("rel", "stylesheet");
  					fileref.setAttribute("type", "text/css");
 					fileref.setAttribute("href", css_file);
					document.getElementsByTagName("head")[0].appendChild(fileref);

		           }
		           // css to the dom before loading the html 
		           $(options.target).find('button.prev,button.next, button.finish, button.refresh,a.screen').click(AjaxRequest);
		           
		           // then the javascript can be loaded 
		           // && $('script[src="'+javascript+'"]').length == 0
		           if(typeof(javascript)!='undefined'  ){

		           	var fileref=document.createElement('script')
  				     fileref.setAttribute("type","text/javascript")
 					 fileref.setAttribute("src", javascript)
					 document.getElementsByTagName("head")[0].appendChild(fileref);
		           	
		           }
			}
		 });
		 return false; // prevent form submission
	}

	$(options.that).find('button.prev,button.next, button.finish, button.refresh,a.screen').click(AjaxRequest);
       });
       
      };
 
})(jQuery);