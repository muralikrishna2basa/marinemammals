$(document).ready(function(){
	
	callbackobservation = function()
	{
		
		$('#previously_observed div.specimens_results tr').click(function(){
			
			test = $.evalJSON($(this).attr('pk'));
			
			if(typeof test != 'undefined') 
			{
			pk = test.ID;
			
			if($('div.specimens_observed').find('a[value='+pk+']').length ==0) // Insure unicity of the observed items
			{
			$('div.specimens_observed').append('<div><a href="" value="'+pk+'">'+pk+'</a></div>');
			$('div.specimens_observed').append("<input name='observed_specimen[]' type='text' style='display:none;' value='"+pk+"'/>");
			}
			}
		});
		
		
	}
	
	$('div.specimens_observed').click(function(e){
	
		if(e.target.tagName=='A')
		{
			$(e.target).parent().remove();
			
		}
		return false;
	});
	
	options2 = { 
    			search_object :"Search_Specimen",
    		    perform_search:"functions/specimens_search.php",
    		    search_results:"specimens_results",
    			callback_results:callbackobservation
    		  };
    	
	 $("#previously_observed div#search_specimens").search(options2);	
	 //////////////////////
	// SPECIMEN HANDLING
	/////////////////////
	// PANEL AUTOPSY
////////////////	

// disable or enable the parameter panel	
$('#nbr_specimens').change(function(event){ 
if ($(this).find(':selected').val() == 1 ) { $('#parameter_fs input,#parameter_fs select').attr('disabled',false);}
else { 
	$('#parameter_fs input,#parameter_fs select').attr('disabled',true);
	$('#parameter_fs input,#parameter_fs select').removeAttr('value'); // clear the elements as it's non sense
}
}).change(); // so that the function load 


// MULTISELECT SPECIMENS
////////////////////////

// visual  
$('div#multiselect_specimen li').live('click',function(){
$(this).addClass('ui-state-selected').siblings().removeClass('ui-state-selected');
});


//  bind click events drop & edit function  

$('div#multiselect_specimen a.drop').live('click',function(){
	$(this).parents('li:first').remove();
    $('fieldset#specimen_fs').removeAttr('edit');
    $('button#confirm_update').hide();
    $('#specimen_fs').removeClass('editing');
	return false;
});

// communication between the form & the list items ( for the edit functionality )

$('div#multiselect_specimen a.edit').live('click',function(){
		
	var data = $.evalJSON($(this).parents('li:first').find('input').attr('value'));

	$('fieldset#specimen_fs .specimen_attribute:visible').each(function(){
		thatid = $(this).attr('name');
		$(this).val(data[thatid]);
	});
    specimen_index = $('div#multiselect_specimen li').index($(this).parents('li:first')); //return the index of the element in the list 
	$('fieldset#specimen_fs').attr("edit",specimen_index);
	
	$('#nbr_specimens').change();
	
	$('button#confirm_update').show();
	
	$('#specimen_fs').addClass('editing');
	
	return false;
});

$('button#confirm_update').click(function(){
	
	var data_fieldset = {};
    $('fieldset .specimen_attribute:visible').each(function(){
	
	data_fieldset[$(this).attr('name')] = $(this).val();

	}); 

	
// before deleting the one to edit, check number of elements inside the corresponding div
	if($('div#multiselect_specimen ul li:visible').length%2) {color_item_class = 'items_even';} else {color_item_class = 'items_odd';}


if($('fieldset#specimen_fs').attr('edit')) {
	
	

// just need to edit the li element with index given in the edit attribute
	specimen_index = $('fieldset#specimen_fs').attr('edit');	
	specimen_element = $('div#multiselect_specimen li').get(specimen_index);

	element_edit = $(specimen_element).find('input').val();
	element_edit_specimen = $.evalJSON(element_edit);
	seqno = element_edit_specimen.seqno;
	if(typeof seqno != "undefined") { data_fieldset['seqno'] = seqno;}

	$(specimen_element).remove();
	
	$('fieldset#specimen_fs').removeAttr('edit');
	
	li_html = '<li title="' + data_fieldset["specie_flow"] + '" class="' + color_item_class + ' ui-multiselect-default ui-element ui-state-temp" style="display: list-item;">';
li_html += '<input name="specimen_data[]" value= \''+ $.toJSON(data_fieldset) +'\' style="display:none;"/> ';
li_html += '<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>';
li_html += '<span class ="number element">' + data_fieldset["nbr_specimens"] + '</span>'; 
li_html += '<span class ="element_specie element">' + data_fieldset["specie_flow"] + '</span>';
li_html += '<span class="element">'+ data_fieldset["Sex"]+'</span>';
if(data_fieldset['mummtag']!=''){li_html += '<span class="element">M.T.: '+ data_fieldset["mummtag"]+'</span>';}
if(data_fieldset['mummtagserie']!=''){li_html += '<span class="element">M.T.S.: '+ data_fieldset["mummtagserie"]+'</span>';}
if(data_fieldset["Length"]!=''){li_html += '<span class="element">Length: '+ data_fieldset["Length"]+' m</span>';}
if(data_fieldset["Weigth"]!=''){li_html += '<span class="element">Weight: '+ data_fieldset["Weigth"]+' Kg</span>';}
//if(data_fieldset["Blubber_thickness"]!=''){li_html += '<span class="element">B.T.: '+ data_fieldset["Blubber_thickness"]+' mm</span>';}
if(data_fieldset["cause_of_death_flow"]!='' && data_fieldset["cause_of_death_flow"]  != null){

li_html += '<span class="element">Cause of Death : '+ data_fieldset["cause_of_death_flow"]+'</span>';}
li_html += '<a class="drop" title="drop" href="#"><div style="color:black;"><span class="drop_spec">Delete</div></span></a> ';
li_html += '<a class="edit " title = "edit" href="#"><div style="color:black;"><span class="edit_spec">Edit</div></span></a></li>';


if(data_fieldset["nbr_specimens"]==1)
{
	if(data_fieldset["Length"].length>0)
	{
		if(isNaN(Number(data_fieldset["Length"])))
		{ 
			alert('The Length must be a number');
			return;
		}
		if(Number(data_fieldset["Length"])>50)
		{
			alert('Length out of bound');
			return;
		}
	}
	if(data_fieldset["Weigth"].length>0)
	{
		if(isNaN(Number(data_fieldset["Weigth"])))
		{ 
			alert('The Weigth must be a number');
			return;
		}
		if(Number(data_fieldset["Length"])>200000)
		{
			alert('Weight out of bound');
			return;
		}
	}
//	if(data_fieldset["Blubber_thickness"].length>0)
//	{
//		if(isNaN(Number(data_fieldset["Blubber_thickness"])))
//		{ 
//			alert('The Blubber thickness must be a number');
//			return;
//		}
//	}
}

if(data_fieldset["specie_flow"].length == 0)
{
alert('The animal specie must be specified');	
}
else
{
$('div#multiselect_specimen ul').append(li_html);
// set the alterned color for the list of items
$('div#multiselect_specimen ul li:visible').each(function(){
	if($('div#multiselect_specimen ul li:visible').index($(this))%2){ $(this).removeClass('items_odd').addClass('items_even');}
	else { $(this).removeClass('items_even').addClass('items_odd');}
});

}
	
	$(this).hide();
	$('#specimen_fs').removeClass('editing');
}
return false;
});

// add a specimen to the list 
$('button#addspecimen').click(function(){
	
 var data_fieldset = {};
    $('fieldset .specimen_attribute:visible').each(function(){
	
	data_fieldset[$(this).attr('name')] = $(this).val();

}); 	

// before deleting the one to edit, check number of elements inside the corresponding div
if($('div#multiselect_specimen ul li:visible').length%2) {color_item_class = 'items_even';} else {color_item_class = 'items_odd';}


li_html = '<li title="' + data_fieldset["specie_flow"] + '" class="' + color_item_class + ' ui-multiselect-default ui-element ui-state-temp" style="display: list-item;">';
li_html += '<input name="specimen_data[]" value= \''+ $.toJSON(data_fieldset) +'\' style="display:none;"/> ';
li_html += '<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>';
li_html += '<span class ="number element">' + data_fieldset["nbr_specimens"] + '</span>'; 
li_html += '<span class ="element_specie element">' + data_fieldset["specie_flow"] + '</span>';
li_html += '<span class="element">'+ data_fieldset["Sex"]+'</span>';
if(data_fieldset['mummtag']!=''){li_html += '<span class="element">M.T.: '+ data_fieldset["mummtag"]+'</span>';}
if(data_fieldset['mummtagserie']!=''){li_html += '<span class="element">M.T.S.: '+ data_fieldset["mummtagserie"]+'</span>';}
if(data_fieldset["Length"]!=''){li_html += '<span class="element">Length: '+ data_fieldset["Length"]+' m</span>';}
if(data_fieldset["Weigth"]!=''){li_html += '<span class="element">Weight: '+ data_fieldset["Weigth"]+' Kg</span>';}
//if(data_fieldset["Blubber_thickness"]!=''){li_html += '<span class="element">B.T.: '+ data_fieldset["Blubber_thickness"]+' mm</span>';}
if(data_fieldset["cause_of_death_flow"]!='' && data_fieldset["cause_of_death_flow"]  != null){

li_html += '<span class="element">Cause of Death : '+ data_fieldset["cause_of_death_flow"]+'</span>';}
li_html += '<a class="drop" title="drop" href="#"><div style="color:black;"><span class="drop_spec">Delete</div></span></a> ';
li_html += '<a class="edit " title = "edit" href="#"><div style="color:black;"><span class="edit_spec">Edit</div></span></a></li>';


if(data_fieldset["nbr_specimens"]==1)
{
	if(data_fieldset["Length"].length>0)
	{
		if(isNaN(Number(data_fieldset["Length"])))
		{ 
			alert('The Length must be a number');
			return;
		}
		if(Number(data_fieldset["Length"])>50)
		{
			alert('Length out of bound');
			return;
		}
	}
	if(data_fieldset["Weigth"].length>0)
	{
		if(isNaN(Number(data_fieldset["Weigth"])))
		{ 
			alert('The Weigth must be a number');
			return;
		}
		if(Number(data_fieldset["Length"])>200000)
		{
			alert('Weight out of bound');
			return;
		}
	}
//	if(data_fieldset["Blubber_thickness"].length>0)
//	{
//		if(isNaN(Number(data_fieldset["Blubber_thickness"])))
//		{ 
//			alert('The Blubber thickness must be a number');
//			return;
//		}
//	}
}

if(data_fieldset["specie_flow"].length == 0)
{
alert('The animal specie must be specified');	
}
else
{
$('div#multiselect_specimen ul').append(li_html);
// set the alterned color for the list of items
$('div#multiselect_specimen ul li:visible').each(function(){
	if($('div#multiselect_specimen ul li:visible').index($(this))%2){ $(this).removeClass('items_odd').addClass('items_even');}
	else { $(this).removeClass('items_even').addClass('items_odd');}
});

}

// var encoded = $.toJSON(data_fieldset); 
return false;
}); 



	 
	 
});