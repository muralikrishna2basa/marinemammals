$(document).ready(function(){
	
	var getFormDatas = function(form){
		
		var datatosend = {};		

	$(form).find('input,select,textarea').each(function()
	{
		if(this.tagName == 'SELECT')
		{
			selected = $(this).find('option:selected');
				
			if(selected.length != 0)
			{
					name = $(this).attr('name');
					value = selected.val();
				
				
					
					datatosend[name]= value;
					
			}
		}
		if(this.tagName == 'INPUT' || this.tagName == 'TEXTAREA')
		{
            
			name_input = this.name;
			
			if(name_input.indexOf("[]")!=-1) // take the arrays into account
			{
				if(name_input in datatosend)
				{
					datatosend[name_input].push(this.value);
				}
				else
				{
					datatosend[name_input] = new Array(this.value);
				}
			}
			else
			{
			datatosend[name_input]= this.value;
			}
		}
	
		
	});
		return datatosend;
	}
	
	
	
	var AjaxRequest = function()
	{
		
		
		form = $(this).parents('form:first');
		
	    datatoSend = getFormDatas(form);
	    
	    
	    
	    datatoSend['button'] = $(this).attr('class');
	    
	    
	    
		$.ajax({
				data:datatoSend,
	  			datatype:'json',
	  			type: 'POST',

				url:'/legacy/functions/flow_remote.php',
				success:function(data)
				{
					
				   data_flow = $.evalJSON(data);
				   
				   html_flow = data_flow.html;
				   
				   container = data_flow.action;
				   
				   javascript = data_flow.js;
				   
				   css_file = data_flow.css;
				 
			      $('#'+container+' div.container_action').html(html_flow);
		           
		           $('#'+container+' button.prev,#'+container+' button.next,#'+container+' button.finish,#'+container+' button.refresh').click(AjaxRequest);
		           
		           if(typeof(css_file)!='undefined')
		           {
		           	var fileref=document.createElement("link");
 					 fileref.setAttribute("rel", "stylesheet");
  					fileref.setAttribute("type", "text/css");
 					fileref.setAttribute("href", css_file);
					document.getElementsByTagName("head")[0].appendChild(fileref);

		           }
		           
		           if(typeof(javascript)!='undefined'){
		           	 var fileref=document.createElement('script')
  				      fileref.setAttribute("type","text/javascript")
 					 fileref.setAttribute("src", javascript)
					 document.getElementsByTagName("head")[0].appendChild(fileref);
		           	
		           }
	    		}
		 });
		 return false; // prevent form submission
	}
	
	$('button.prev,button.next,button.finish,button.refresh').click(AjaxRequest);
});