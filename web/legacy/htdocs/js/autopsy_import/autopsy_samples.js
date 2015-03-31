$(document).ready(function(){
	
	var checkToUpdateLesionSample = function(element)
	{
		var checkupdate = false;
		
		elementvaljson = element.find('input.organlesionsample').val();
		
		regelementvaljson = element.find('input.regorganlesionsample').val();
		
		if(regelementvaljson == undefined ) { return true;}
		
		elementvaljson_eval = $.evalJSON(elementvaljson);
		
		regelementvaljson_eval = $.evalJSON(regelementvaljson);
		
		
		
		for(var i in elementvaljson_eval)
		{
			if(i=='UPD' || i == 'DEL'){ continue;}

			if($.toJSON(regelementvaljson_eval[i]) != $.toJSON(elementvaljson_eval[i]))
			{
				return true;	
			}
		}
		 return checkupdate;
		
	}
	var getJsonElement = function(element,value)
	{
		eljson = element.val();
	
		
		eljsoneval = $.evalJSON(eljson); 
		
		
		return eljsoneval[value];
		
	}
	var ChangeJsonElement = function(element,key,value)
	{
		to_eval_chgf = element.val();
		
		
		eval_chgf = $.evalJSON(to_eval_chgf); 
		
		eval_chgf[key] = value;
		
		eval_json_chgf = $.toJSON(eval_chgf);
		
		element.val(eval_json_chgf);
		
		return eval_chgf;
	}	
	
	var getorganslesionsfunction = function(e){
		
		// go trough all table data's, in case a registered appeared => 
		
		
	// 	$(this).parents('td:first').siblings().find('input[type=checkbox]:checked').click().siblings().remove();
		
		organ_code = $(e.target).val();
		
		actualorgan = $(e.target).find('option.selected').val();

		// do nothing in case the selected value is not in the optgroup part or is not the parent action
		if($(e.target).find('[value='+organ_code+']').parent().attr('tagName') !='OPTGROUP' && organ_code !='PARENT')
		{ 
			return false;
		}
		
		$(e.target).addClass('targeted');
		
	  	$.ajax({
	  			data:{'organselect':organ_code,'actualorgan':actualorgan},
	  			datatype:'json',
				url:'functions/loadorganslesions.php',
				success:function(data)
				{
					
				   $('.targeted').parents('td:first').addClass('targeted').html(data);
				   
				   $('.targeted').siblings().each(function()
					{
			 			if($(this).find('input.organlesionsample').length == 1)
			 			{
			 			
			 				organ_code = $('.targeted select.organ').val();
			 					
			 				lesion = $.evalJSON(organ_code);
			 	
			 				lesionsample_json  = $(this).find('input.organlesionsample').val();
			 	
			 				lesionsample = $.evalJSON(lesionsample_json); 
			 	
			 				if(lesionsample['Seqno'] != undefined)
			 				{
			 					oldlesion = lesionsample['lesion'];
			 				
			 					lesionsample['lesion'] = lesion["lesion"];
			 				
			 					lesionsample["oldlesion"] = oldlesion; // remember the old lesion ( since it is part of the primarey key) might 
			 					// be a bad design... but for now, it's left as it is // btw it is possible that a sample point to multiple organs
			 					
			 					lesionsample['UPD'] = "TRUE"; 	
			 					
			 					if(lesionsample['DEL']!=undefined) {lesionsample['DEL'] = "FALSE"; }
			 					
			 					$(this).find('input[type=checkbox]').get(0).checked = true;
			 					
			 					new_lesionsample_json = $.toJSON(lesionsample);
			 	
			 					$(this).find('input.organlesionsample').val(new_lesionsample_json);

			 					
			 					
			 					$(this).addClass("SmplteToUpdate").removeClass("SmplteToDelete");
			 	
			 				
				 		
			 		//		ogn = oldlesion[0];lsn = oldlesion[1]; server side set-up
			 		
				 				$(this).find("span.UpdOrgan").css("visibility","visible");
			 
				 			}
			 				else
			 				{
			 					$(this).find('input[type=checkbox]:checked').click();
			 				}
				 		}
			 	
				});
				   
				   
				   $('.targeted select.organ').change(getorganslesionsfunction);
				   
				   $('.targeted').removeClass('targeted'); 
				}
	  		});
			
		
	};
	
	/* 
		when a new organ is selected, then the action uncheck the checked boxes in the corresponding row 
	    and an ajax request is sent to get the lesions organs or the sane ones 
	*/
	$('.organ_select select.organ').change(getorganslesionsfunction);
	
	
	/* When the user click on a checkbox, then the checkbox receive all needed informations prepared to be send to the server */
	
	$('table.samples input[type=checkbox]').click(function()
	{
		if(this.checked == true)
		{
			// obviously coming from a previously "to delete" registered sample 
			if($(this).parents('td:first').find('input.organlesionsample').length == 1)
			{
				
				lesion_sample = $(this).parents('td:first').find('input.organlesionsample');
				
				lesion_sample_json = lesion_sample.val();
				
				lesion_sample_eval = $.evalJSON(lesion_sample_json);
				
				test = checkToUpdateLesionSample($(this).parents('td:first'));
				
				if(test == true)
				{
					$(this).parents('td:first').addClass('SmplteToUpdate');	
					ChangeJsonElement($(this).parents('td:first').find('input.organlesionsample'),"UPD","TRUE");
				}
				else
				{
					ChangeJsonElement($(this).parents('td:first').find('input.organlesionsample'),"UPD","FALSE");
					$(this).parents('td:first').removeClass('SmplteToUpdate');	
				}
			
				ChangeJsonElement(lesion_sample,'DEL','FALSE');
				
				$(this).parents('td:first').removeClass('SmplteToDelete');
				
			}
		    else // create the sample to register 
		    {
				index_sample = $(this).parents('tr').find('td').index($(this).parents('td:first'));
			
				analyze_dest = $(this).parents('table:first').find('tr.analyze_dest th')[index_sample].textContent;
			
				conservation_code_html = $(this).parents('table:first').find('tr.conservation_mode th')[index_sample];
			
				conservation_mode = $(conservation_code_html).find('select').val();
			
				lesion_json = $(this).parents('tr:first').find('td:first select').val();
			
				lesion = $.evalJSON(lesion_json);
		
				sample_type = $(this).parents('td:first').find('select.SampleType').val();
			
				var toencode = {'lesion':lesion['lesion'],'conservation_mode':conservation_mode,'analyze_dest':analyze_dest,'sample_type':sample_type};
			
				json_encoded = $.toJSON(toencode);
					
				$(this).parent().append("<input class='organlesionsample' name ='organlesionsample[]' value='"+json_encoded+"' style='display:none;'/>");
				htmltoappend = $("div.RegDetailsSample").html();
				
				$('table.samples tr.initbodyrow td:eq(1) select.minwidth').clone(true).appendTo(this.parentNode);
				
			}
		}
		else // in case the user uncheck the checkbox => ok  
		{
			organlesionsample_to_eval = $(this).parents('td:first').find('input.organlesionsample').val();	
			
			organlesionsample = $.evalJSON(organlesionsample_to_eval); 
			
			RegSample = organlesionsample['Seqno']; 
			
			
			
			if(RegSample != undefined)
			{
				if(organlesionsample['DEL'] == undefined || organlesionsample['DEL'] == 'FALSE' )
				{
					organlesionsample['DEL'] = 'TRUE';
				
					organlesionsample_json = $.toJSON(organlesionsample);
				
					$(this).parents('td:first').find('input.organlesionsample').val(organlesionsample_json);
				
					$(this).parents('td:first').addClass('SmplteToDelete').removeClass("SmplteToUpdate");
				}	
			}
			else
			{
				
				$(this).parents('td:first').find('input.organlesionsample,select').remove();
				$(this).parents('td:first').find('span').html('');
				$(this).parents('td:first').removeClass('SmplteToUpdate');
			}
		}
	});
	
	/* When the user is changing the default mode of conservation => the entire corresponding column change accordingly */

	$('table.samples th select.conservation_mode').change(function(){
		
		column_index = $(this).parents('tr').find('th').index($(this).parents('th:first'));
		
		conservation_mode = $(this).val();

		
		$('table.samples tbody tr').each(function(){
				
				td = $(this).find('td').get(column_index);
				
				
				if($(td).find('input.organlesionsample').length == 1 && $(td).find('input[type=checkbox]').get(0).checked == true)
				{
					
					organlesionsample = ChangeJsonElement($(td).find('input.organlesionsample'),"conservation_mode",conservation_mode);
					
					test = checkToUpdateLesionSample($(td));
					if(test == true)
					{
						ChangeJsonElement($(td).find('input.organlesionsample'),"UPD","TRUE");
						$(td).addClass("SmplteToUpdate");
						$(td).find('span.UpdConsMode').css('visibility','visible').html(conservation_mode);
				
					}
					else
					{
						ChangeJsonElement($(td).find('input.organlesionsample'),"UPD","FALSE");
						$(td).removeClass("SmplteToUpdate");
						$(td).find('span.UpdConsMode').css('visibility','hidden');	
					}
				}
				
		});		
	});
	// change default sample type 
	$('table.samples tbody select.SampleType').change(function(){
		
			td = $(this).parents('td:first');
			new_sample_type = $(this).val();
		if(td.find('input.organlesionsample').length == 1 )
		{
			organlesionsample = ChangeJsonElement($(td).find('input.organlesionsample'),"sample_type",new_sample_type);
			
			test = checkToUpdateLesionSample($(td));
					
			if(test == true && $(td).find('input[type=checkbox]').get(0).checked == true) // if the item is not deleted 
			{
						ChangeJsonElement($(td).find('input.organlesionsample'),"UPD","TRUE");
						$(td).addClass("SmplteToUpdate");
			}
			else if(test == false)
			{
						ChangeJsonElement($(td).find('input.organlesionsample'),"UPD","FALSE");
						$(td).removeClass("SmplteToUpdate");
						$(this).parents('td:first').find('span.UpdConsMode').css('visibility','hidden');
			}
		
		}
	});
	
	// if conservation mode is set manually, then it change the corresponding sample 
	$('table.samples tbody div select.CsvModeBody').change(function(){
		
		conservation_mode_to_change = $(this).val();
		
		organlesionsample = $(this).parents('td:first').find('input.organlesionsample');
		
		if(organlesionsample.length == 1)
		{
			
			
			oldconservationmode = $(this).parents('td:first').find('span.RegConsMode').html();
			
			oldconservationmoderegistered  = getJsonElement(organlesionsample,"conservation_mode");

			organlesion_smple = ChangeJsonElement(organlesionsample,"conservation_mode",conservation_mode_to_change);

			test = checkToUpdateLesionSample($(this).parents('td:first'));
			
			if(test == true)
			{
			
					ChangeJsonElement($(this).parents('td:first').find('input.organlesionsample'),"UPD","TRUE");
					$(this).parents('td:first').addClass("SmplteToUpdate");
					$(this).parents('td:first').find('span.UpdConsMode').css('visibility','visible').html(conservation_mode_to_change);
		
			}
			else
			{
				ChangeJsonElement($(this).parents('td:first').find('input.organlesionsample'),"UPD","FALSE");
				$(this).parents('td:first').removeClass("SmplteToUpdate");
				$(this).parents('td:first').find('span.UpdConsMode').css('visibility','hidden');
			}
		
			
					//	$(this).siblings().find('input.ToChangeConsMode').show().val(oldconservationmode);
		}
	});
	
	// add a row if the user is pressing the add button 
	$('button.addsample').click(function(){
		
		$('table.samples tr.initbodyrow').clone(true).removeClass('initbodyrow').show().appendTo('table.samples tbody');
	
	});
	
	// delete the row if the user is pressing the delete button 
	
	$('button.delsample').click(function(e){
		
		todelete = 1;
		
			
			// check if there is samples in the row that contains a Seqno
			$(this).parents('tr:first').find('td.organ_select').siblings().each(function(){
				
				
				
				// in case the sample is checked 
				if($(this).find('input.organlesionsample').length == 1)
				{
					organlesionsample_to_eval = $(this).find('input.organlesionsample').val();
				
					organlesionsample = $.evalJSON(organlesionsample_to_eval); 
				   
					// if there is at least one registered sample then, don't delete the row but issue a click on each selected items 
					if(organlesionsample['Seqno'] != undefined)
					{
						todelete = 0; 
						
						organlesionsample['DEL'] = 'TRUE';
						
					//	if(organlesionsample['UPD'] != undefined ) {organlesionsample['UPD'] = 'FALSE';}
						
						organlesionsample_json = $.toJSON(organlesionsample);
				
						$(this).find('input.organlesionsample').val(organlesionsample_json);
						$(this).addClass('SmplteToDelete').removeClass("SmplteToUpdate");
						$(this).find('input[type=checkbox]').get(0).checked = false ;  	
					}
					else  // uncheck all items on the row 
					{
						$(this).find('input[type=checkbox]').get(0).checked = false;
						$(this).find('input.organlesionsample,select').remove();
						$(this).find('span').html('');
						$(this).removeClass('SmplteToUpdate');
					}
				}
				
			});
			
			if(todelete == 1 && $('table.samples tbody tr:visible').length != 1)
			{
			 	$(e.target).parents('tr:first').remove();
			}
		
	});
	
	
	// toggle the visibility of the default samples 
	
	$('button.toggledefault').click(function(){
		
		if($(this).hasClass('show'))
		{
			$('table.samples tr.default_sample').show();
		}
		else if($(this).hasClass('hide'))
		{
			$('table.samples tbody tr.default_sample').each(function(){
				
				if($(this).find('td input[type=checkbox]:checked').length == 0){ $(this).hide();}
			});

			if($('table.samples tbody tr:visible').length == 0)
			{
				$('button.addsample').click();
			}	
		}
		
		$(this).hide().siblings('.toggledefault').show();
		
	})
	
	// by default it is assumed that the default samples are hidden
	$('button.toggledefault.hide').click();
	
	

	
	// visually better
	$('table.samples tbody div select').hover(
											function(){$(this).addClass('fullwidth').removeClass('minwidth');},
											function(){$(this).addClass('minwidth').removeClass('fullwidth');}
										 );
	
	
});