var relevantCols = 7;
var totalCols = relevantCols + 2;
var possible_analysis_dest = [];
var possible_conservation_mode = [];
/* = [
 {
 lesion: {
 organ: '',
 processus: ''
 },
 conservation_mode: '',
 analyze_dest: '',
 sample_type: ''
 }
 ];*/

var getCellCoord = function (cell, rowid, colid, trueRowNb) {
    if (rowid !== null && colid !== null && rowid >= 0 && colid >= 0) {
        return [rowid, colid];
    }
    else {
        var trIndex;
        if (trueRowNb) {
            trIndex = $('table.samples tbody tr:visible:last').index();
        }
        else {
            trIndex = Number($tr.attr('class').replace('row', ''));
        }
        //var totaltd=$(cell).siblings('td.sample_select').count()+1;
        $tr = $(cell.parentNode);
        var tdIndex = $tr.children().index(cell) - 1;
        return [trIndex, tdIndex]; //tr.class-row, td index
    }
};

var changeSample = function (cell) {
    var coord = getCellCoord(cell, null, null, true);
    var table = $(cell).parents('table.samples')[0];
    var row = cell.parentNode;

    var available = $(cell).find('input.availability')[0].checked;
    var sampletype = $(cell).find('select.SampleType')[0].value;
    var conservation_mode = $(cell).find('select.CsvModeBody')[0].value;

    var lesion_select = $(row).find('select.organ_sample')[0];
    var lesion = JSON.parse(lesion_select.value);

    var actuallyDoSomething = sampletype !== '' || conservation_mode !== '';

    var lesion_notset = lesion['lesion'][0] === 'ROOT';
    if (!lesion_notset && actuallyDoSomething) {
        actuallyDoSomething = false;
        var tobe_deleted = $(row.cells[totalCols - 1]).find('input.tobedeleted')[0].checked;

        if (possible_analysis_dest.length < relevantCols) {
            getAllAnalyzeDests('samples');
        }
        if (possible_conservation_mode.length < relevantCols) {
            getAllConservationModes('samples');
        }

        var analyze_dest = getAnalysisDest(null, coord[1]);

        var organlesionsample_input = $(cell).find('input.organlesionsample')[0];
        var organsamples = {};
        if (typeof organlesionsample_input === 'undefined') {
            $(cell).append("<input class='organlesionsample' name ='organlesionsample[]' value='' style='display:none;'/>");
            organlesionsample_input = $(cell).find('input.organlesionsample')[0];
            //organsamples = {};
        }
        else {
            organsamples = JSON.parse(organlesionsample_input.value);
        }
        var already_registered = true;
        if (typeof (organsamples.SEQNO) === 'undefined') {
            already_registered = false;
        }

        if (already_registered) {
            if (tobe_deleted) {
                organsamples.DEL = 'TRUE';
            }
            else {
                organsamples.DEL = 'FALSE';
                if (organsamples.CONSERVATION_MODE != conservation_mode) {
                    organsamples.CONSERVATION_MODE = conservation_mode;
                    organsamples.UPD = 'TRUE';
                }

                if (organsamples.ANALYZE_DEST != analyze_dest) {
                    organsamples.ANALYZE_DEST = analyze_dest;
                    organsamples.UPD = 'TRUE';
                }

                if (organsamples.SPE_TYPE != sampletype) {
                    organsamples.SPE_TYPE = sampletype;
                    organsamples.UPD = 'TRUE';
                }

                if (available) {
                    organsamples.UPD = 'TRUE';
                    organsamples.AVAILABILITY = 'yes';
                }
                else {
                    organsamples.UPD = 'TRUE';
                    organsamples.AVAILABILITY = 'no';
                }

            }
            if (organsamples.UPD === 'TRUE' || organsamples.DEL === 'TRUE') {
                actuallyDoSomething = true;
            }
        }
        else {
            if (organsamples.CONSERVATION_MODE != conservation_mode) {
                organsamples.CONSERVATION_MODE = conservation_mode;
                actuallyDoSomething = true;
            }

            if (organsamples.ANALYZE_DEST != analyze_dest) {
                organsamples.ANALYZE_DEST = analyze_dest;
                actuallyDoSomething = true;
            }

            if (organsamples.SPE_TYPE != sampletype) {
                organsamples.SPE_TYPE = sampletype;
                actuallyDoSomething = true;
            }

            if (available && organsamples.AVAILABILITY === 'no' || typeof (organsamples.AVAILABILITY) === 'undefined') {
                organsamples.AVAILABILITY = 'yes';
                actuallyDoSomething = true;
            }
            if (!available && organsamples.AVAILABILITY === 'yes' || typeof (organsamples.AVAILABILITY) === 'undefined') {
                organsamples.AVAILABILITY = 'no';
                actuallyDoSomething = true;
            }
        }
        $.extend(true, organsamples, lesion);
        $(organlesionsample_input).val(JSON.stringify(organsamples));
    }
    return !lesion_notset && actuallyDoSomething;
};

var getConservationMode = function (cell, rowid) {
    if (typeof rowid !== 'undefined') {
        return possible_conservation_mode[rowid];
    }
    else return possible_conservation_mode[getCellCoord(cell)[1]];
};

var getAnalysisDest = function (cell, rowid) {
    if (typeof rowid !== 'undefined') {
        return possible_analysis_dest[rowid];
    }
    else return possible_analysis_dest[getCellCoord(cell)[1]];
};

var changeConservationMode = function (idx, value) {
    if (possible_conservation_mode.length < relevantCols) {
        getAllConservationModes('samples');
    }
    possible_conservation_mode[idx] = value;
};

var getAllConservationModes = function (tableId) {
    var table = document.getElementById(tableId);
    for (var i = 0, row; row = table.rows[i]; i++) {
        if (row.className.indexOf('conservation_mode') == 0) {
            for (var k = 0, consmode_col; consmode_col = row.cells[k]; k++) {
                if (k > 0) {
                    var consmode = $(consmode_col).find('select.conservation_mode')[0];
                    if (typeof consmode === 'undefined') {
                        continue;
                    }
                    possible_conservation_mode[k - 1] = consmode.value;
                }
            }
        }
    }
};

var getAllAnalyzeDests = function (tableId) {
    var table = document.getElementById(tableId);
    for (var i = 0, row; row = table.rows[i]; i++) {
        if (row.className.indexOf('analyze_dest') == 0) {
            for (var k = 0, consmode_col; consmode_col = row.cells[k]; k++) {
                if (k > 0) {
                    possible_analysis_dest[k - 1] = consmode_col.innerHTML;
                }
            }
        }
    }
};

var getorganslesionsfunction = function (e) {
    // go trough all table data's, in case a registered appeared =>

    // 	$(this).parents('td:first').siblings().find('input[type=checkbox]:checked').click().siblings().remove();

    organ_code = $(e.target).val();
    actualorgan = $(e.target).find('option.selected').val();

    // do nothing in case the selected value is not in the optgroup part or is not the parent action, only activate in case of parent
    if ($(e.target).find('[value=' + organ_code + ']').parent().attr('tagName') != 'OPTGROUP' && organ_code != 'PARENT') {
        return false;
    }

    var tr_reg= $(e.target).parents('tr.reg_sample ')[0];
    if(typeof tr_reg !== 'undefined'){
        $('p#organ_change_dialog').dialog('open');
    }


    $(e.target).addClass('targeted');

    $.ajax({
        data: {'organselect': organ_code, 'actualorgan': actualorgan},
        datatype: 'json',
        url: '/legacy/functions/loadorganslesions.php',
        success: function (data) {
            $('.targeted').parents('td:first').addClass('targeted').html(data);
            $('.targeted').siblings('td.sample_select').each(function () {
                var $anySelect = $(this).find('select.CsvModeBody');//just to have one
                $anySelect.trigger("change");
            });
            $('.targeted select.organ_sample').change(function (e) {
                getorganslesionsfunction(e)
            });
            $('.targeted').removeClass('targeted');
        }
    });
};

$(document).ready(function () {

    $('p#organ_change_dialog').dialog({
        autoOpen: false,
        modal: true,
        draggable: false
    });

    // execute organ_select.js
    /*var fileref = document.createElement('script');
     fileref.setAttribute("type", "text/javascript");
     fileref.setAttribute("src", "/legacy/js/organ_select.js");
     document.getElementsByTagName("head")[0].appendChild(fileref);*/

    $('table.samples td.sample_select select, table.samples td.sample_select input').not('input.addRegSample').change(function () {
        var td = $(this).parents('td.sample_select')[0];
        var actuallyDoneSomething = changeSample(td);
        if (actuallyDoneSomething) {
            if ($(td).hasClass('NewSampleDefault') && !$(td).hasClass('SmplteToDelete')) {
                $(td).removeClass('NewSampleDefault').addClass('NewSample');
            }
        }
    });

    $('input.addRegSample').change(function () {
        var $td = $(this).parents('td.sample_select');
        var $exampleTd = $($('table.samples tr.initbodyrow td.sample_select').get(0));
        $td.replaceWith($exampleTd.clone(true).show().addClass('NewSampleDefault'));

        $(this).remove();
    });

    /*$('table.samples input[type=checkbox]').click(function () {
     var td = $(this).parents('td.sample_select')[0];
     changeSample(td, this.checked);
     });*/

    $('table.samples th select.conservation_mode').change(function () {
        var $tr = $(this).parents('tr.conservation_mode');
        var $th = $(this).parent('th');
        var thIndex = $tr.children().index($th) - 1;

        var v = $(this)[0].value;
        changeConservationMode(thIndex, v);
    });

    // if the delete checkbox is clicked
    $('input.tobedeleted').change(function () {
        var cell = $(this).parents('td.sample_delete')[0];
        var row = cell.parentNode;
        var $tds = $(row).find('td.sample_select');
        var $anySelect = $tds.find('select.CsvModeBody');//just to have one
        var $relevantInputSelect = $tds.find('input.availability, select.CsvModeBody, select.SampleType');
        if (this.checked === true) {
            $tds.removeClass('NewSample').addClass('SmplteToDelete');
            $relevantInputSelect.attr('disabled', true);
        }
        else {
            $tds.removeClass("SmplteToDelete");
            $relevantInputSelect.attr('disabled', false);
        }
        $anySelect.trigger("change");
    });

    // add a row if the user is pressing the add button
    $('button.addsample').click(function () {
        var c;
        var lastrowclass = $('table.samples tbody tr:visible:last').attr('class');
        if (typeof lastrowclass !== 'undefined') {
            c = Number(lastrowclass.replace('row', '')) + 1;
        }
        else {
            c = $('table.samples tbody tr:visible:last').index() + 1;
        }
        //var c = $('table.samples tbody tr:visible:last').attr('class').replace('row','') || $('table.samples tbody tr:visible:last').index() + 1;
        $('table.samples tr.initbodyrow').clone(true).removeClass('initbodyrow').addClass('row' + c).addClass('new_sample').show().appendTo('table.samples tbody').children('td.sample_select').addClass('NewSampleDefault');
    });

    // toggle the visibility of the default samples

    $('button.toggledefault').click(function () {

        if ($(this).hasClass('show')) {
            $('table.samples tr.default_sample').show();
        }
        else if ($(this).hasClass('hide')) {
            $('table.samples tbody tr.default_sample').each(function () {

                if ($(this).find('td input[type=checkbox]:checked').length == 0) {
                    $(this).hide();
                }
            });

            if ($('table.samples tbody tr:visible').length == 0) {
                $('button.addsample').click();
            }
        }

        $(this).hide().siblings('.toggledefault').show();

    });

    // by default it is assumed that the default samples are hidden
    $('button.toggledefault.hide').click();

    // visually better
    $('table.samples tbody div select').hover(
        function () {
            $(this).addClass('fullwidth').removeClass('minwidth');
        },
        function () {
            $(this).addClass('minwidth').removeClass('fullwidth');
        }
    );

    /*
     when a new organ is selected, then the action uncheck the checked boxes in the corresponding row
     and an ajax request is sent to get the lesions organs or the sane ones
     */
    $('.organ_select select.organ_sample').change(function (e) {
        getorganslesionsfunction(e);
    });
});