$(document).ready(function () {
    /*
     Autocomplete Persons

     */
    var name_autopsiers =  $.parseJSON($('.autopsy_hidden_autopsiers').html());
    var name_assistants = $.parseJSON($('.autopsy_hidden_assistants').html());
    var name_collectors = $.parseJSON($('.autopsy_hidden_collectors').html());

    var maxlength = Math.max(name_autopsiers.length, name_assistants.length, name_collectors.length);

    var options = {
        minChars: 0,
        width: 195,
        max: maxlength,
        mustMatch: true,
        autoFill: true,
        scrollHeight: 220,
        formatItem: function (row, i, max) {
            return row.LAST_NAME + ' ' + row.FIRST_NAME;
        },
        formatMatch: function (row, i, max) {
            return row.LAST_NAME + ' ' + row.FIRST_NAME;
        },
        formatResult: function (row) {
            return row.LAST_NAME + ' ' + row.FIRST_NAME;
        }
    };

    $("#autopsy_autopsier_flow").autocomplete(name_autopsiers, options);
    $("#autopsy_assistant_flow").autocomplete(name_assistants, options);
    $("#autopsy_collector_flow").autocomplete(name_collectors, options);

    $('.contact_attribute').result(function (event, data, formatted) {
        if (typeof data != 'undefined') {
            $(this).attr('pk', data.SEQNO);
        }
        else {
            $(this).removeAttr('pk');
        }

    });

    /*
     Autocomplete Institutes

     */
    /*
     name_institutes = $.evalJSON($('.autopsy_hidden_institutes').html());
     $("#autopsy_Institute_flow").autocomplete(name_institutes,
     {
     minChars: 0,
     width: 195,
     max: name_institutes.length,
     mustMatch: true,
     autoFill: true,
     formatItem: function (row, i, max) {
     return "[" + row.CODE + "]" + "[" + row.NAME + "]";
     },
     formatMatch: function (row, i, max) {
     return row.NAME;
     },
     formatResult: function (row) {
     return row.NAME;
     }
     });
     $('#autopsy_Institute_flow').result(function (event, data, formatted) {
     if (typeof data != 'undefined') {
     $('#autopsy_Institute_flow').attr('pk', data.PSN_SEQNO);
     }
     else {
     $('#autopsy_Institute_flow').removeAttr('pk');
     }
     });*/


    /*
     Permit to add multiple institutes or Persons to an observation

     */
    $('button.autopsy_addtab').click(function () {

       if ($(this).hasClass('autopsier_btn')) {
           input_value = $(this).parents('div.qfelement:first').find('input').val();
           input_pk = $(this).parents('div.qfelement:first').find('input').attr('pk');

           if ($('#autopsy_autopsier_opt option[pk=' + input_pk + ']').length == 0 && typeof input_pk != 'undefined') {
               $('#autopsy_autopsier_opt').append('<option  pk=' + input_pk + '>' + input_value + '</option>');
               $('#autopsy_autopsier_opt').parents('div:first').append('<input name="autopsier_opt[]" style="display:none;" value="' + input_pk + '"/>');
           }
        }
        else if ($(this).hasClass('assistant_btn')) {
            input_value = $(this).parents('div.qfelement:first').find('input').val();
            input_pk = $(this).parents('div.qfelement:first').find('input').attr('pk');

            if ($('#autopsy_assistant_opt option[pk=' + input_pk + ']').length == 0 && typeof input_pk != 'undefined') {
                $('#autopsy_assistant_opt').append('<option  pk=' + input_pk + '>' + input_value + '</option>');
                $('#autopsy_assistant_opt').parents('div:first').append('<input name="assistant_opt[]" style="display:none;" value="' + input_pk + '"/>');
            }
        }
       else if ($(this).hasClass('collector_btn')) {
           input_value = $(this).parents('div.qfelement:first').find('input').val();
           input_pk = $(this).parents('div.qfelement:first').find('input').attr('pk');

           if ($('#autopsy_collector_opt option[pk=' + input_pk + ']').length == 0 && typeof input_pk != 'undefined') {
               $('#autopsy_collector_opt').append('<option  pk=' + input_pk + '>' + input_value + '</option>');
               $('#autopsy_collector_opt').parents('div:first').append('<input name="collector_opt[]" style="display:none;" value="' + input_pk + '"/>');
           }
       }

    });

    // delete item if existing
    $('#autopsy_multiselect_contact').click(function (e) {
        if (e.target.tagName == 'OPTION') {
            if (typeof $(e.target).attr('pk') != 'undefined') {
                $('input[value=' + $(e.target).attr('pk') + ']').remove();
            }
            $(e.target).remove();

        }

    });

}); // DOCUMENT READY 
