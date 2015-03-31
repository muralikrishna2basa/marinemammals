$(document).ready(function(){
	$('button.addlesion').click(function(){
		
		$('table.diagnosis tr.init').clone(true).removeClass('init').show().appendTo('table.diagnosis tbody');
	
	});
	
	$('button.dellesion').click(function(e){
		$(e.target).parents('tr:first').remove();
	});
	
	var getDatasDiagnosis = function(form){
		
		
		
		var datatosend = {};		
		
		

		$(form).find('input:not(.diagnosis),select,textarea').each(function()
		{
			
			if(this.tagName == 'SELECT')
			{
				selected = $(this).find('option:selected');
				
				if(selected.length != 0)
				{
					name = $(this).attr('class').split(' ')[0];
					value = selected.val();
				
				
					
					datatosend[name]= value;
					
			}
		}
		if(this.tagName == 'INPUT' || this.tagName == 'TEXTAREA')
		{
            
			name_input = $(this).attr('class');
			
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
	
	$('table.diagnosis tr').change(function(){ 
		
          datatosend =  getDatasDiagnosis(this);
        
          $(this).find('input.diagnosis').val($.toJSON(datatosend));
          
              //   alert($.toJSON(datatosend));
	});
});