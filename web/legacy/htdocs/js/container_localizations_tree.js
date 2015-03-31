$().ready(function(){

/*  DRAG AND DROP 
	
	Hack : since the drag & drop functionality is based on a box model, this means that no hidden(display:none) 
	 	   div can interact when the events are binded. This is the reason of the ($(this).show().siblings().hide();)
	 	   
	Disabled by default since it slowed down the webpage display

*/
//$("div#Layout_content > div").each(function(){
//	
//	
//	if($(this).attr('id') == 'containers' || $(this).attr('id') == 'manage_samples')
//	{
//	$(this).show().siblings().hide();
//	
//	$(this).find(".drag a")
//        .bind( "dragstart", function( event ){
//                // ref the "dragged" element, make a copy
//                var $drag = $( this ), $proxy = $drag.clone();
//                // modify the "dragged" source element
//                $drag.addClass("outline");
//                // insert and return the "proxy" element                
//                return $proxy.appendTo( document.body ).addClass("ghost");
//                })
//        .bind( "drag", function( event ){
//                // update the "proxy" element position
//                $( event.dragProxy ).css({
//                        left: event.offsetX,
//                        top: event.offsetY
//                        });
//                })
//        .bind( "dragend", function( event ){
//                // remove the "proxy" element
//                $( event.dragProxy ).fadeOut( "normal", function(){
//                        $( this ).remove();
//                        });
//                // if there is no drop AND the target was previously dropped
//                if ( !event.dropTarget && $(this).parent().is(".drop") ){
//                        // output details of the action
//                        // put it in it's original div...
//                      
//                        $(this).remove();
//                        }
//                // restore to a normal state
//                $( this ).removeClass("outline");      
//               
//                });
//	$(this).find(".drop")
//        .bind( "dropstart", function( event ){
//                // don't drop in itself
//                if ( this == event.dragTarget.parentNode ) return false;
//                // activate the "drop" target element
//                $( this ).addClass("active");
//                })
//        .bind( "drop", function( event ){
//                // if there was a drop, move some data...
//               
//                if(this.tagName == 'INPUT'  )
//                { 
//                	 pk = $(event.dragTarget).attr('pk'); // i.e issue
//                	
//                	 pk = $.evalJSON(pk);
//                	 
//                	 $(this).val(pk.SEQNO);
//                	
//                }
//                else 
//                {
//                	
//                	if($(this).children('a').size() == 0)
//                	{
//                
//               			 pk = $(event.dragTarget).attr('pk'); // i.e issue
//                
//               			 $test = $(event.dragTarget).clone(true);
//                
//               			 $test.attr('pk',pk);
//                
//           
//               			 $( this ).append( $test);
//                
//               			 $test.removeClass("outline");
//               
//                
//                	}
//                }	
//
//                })
//        .bind( "dropend", function( event ){
//                // deactivate the "drop" target element
//                $( this ).removeClass("active");
//	});	
//	}
//	
//});
//$("#Layout_navigation div.admin_navigation li.isclicked").click();

//  On Form Submit, append the pk to the hidden input. allow only one dropped element in the div box.                
$('form.cms button').click(function(){	
        	test = 0;
        	$(this).parents('div.row').find('div.drop').each(function(){
        	
        		if($(this).children('a').size() == 0)
        		{
        			test = 1;
        			$('form.cms div.errormessage').html('An error occured : please drop the item');
        			return false;
        		}
        		else
        		{
        			pk = $(this).children('a').attr('pk');
        				
        			value = $(this).children('a').html();
        	
        			$(this).find('input').attr('value',pk);
        		}
        		
        	});
        	if( test == 1) { return false;}
        
			$("form.cms").submit();
});
/*  COLLAPSE AND EXPAND */

// Expand or Collapse items on the list
$('div.inittree > ul').click(function(e){
		
		if($(e.target).hasClass('item'))
		{
			
			$(e.target).parent().children('img.item').toggle();
			$(e.target).parent().find('ul:first').toggle();
		
		}	
		
});
// Expand and Collapse button 
$('div.tree_toolbar button').click(function(){
        	$(this).hide().siblings().show();
        	
        	if($(this).hasClass('expand'))
        	{
        		$('div.inittree').find('ul').show();
        	}
        	if($(this).hasClass('collapse'))
        	{
        		$('div.inittree').find('ul.init ul ul').hide();
        	}
        	
        	
});      
// Redirect to Samples

$('div#tree_container a,div.inittree a').click(function(){
	
	$('a[href="#manage_samples"]').click();
	
	 $('div#search_samples div.Search_Box div.filters select option:selected[value="localization seqno"]').each(function(){
	 	
	 	$(this).parents('div.Search_Box').remove();
	 	
	 });
	
	
	
	
	var $clone = $('div#search_samples div.Search_Box:first').clone(true);

	
	$clone.show().find('div.filters select option[value="localization seqno"]').attr('selected','selected');
	
	$clone.find('div.tokens select').html('<option selected = "selected">=</option>'); 
	
	$clone.find('div.fields input').parent().show();
	
	pk = $(this).attr('pk');
	
	pk = $.evalJSON(pk);
	
	$clone.find('div.fields input').val(pk.SEQNO);
	
	$clone.find('div.fields select').parent().hide();
	
	 $('div#search_samples div.Search_Box:first').after($clone);
	
	 
	 $('div#search_samples a.Search_for').click();

	
	return false;
});

});