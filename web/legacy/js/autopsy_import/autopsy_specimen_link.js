searchSpecimenUpdCard = function (pk){
    var datatosend = {};
    datatosend['specimen_link'] = pk;
    $('#autopsy_importation_tool div.container_action input.specimenlink').val(pk);

    $.ajax({
        url: '/legacy/functions/autopsy_specimen_link.php',
        type: 'POST',
        datatype: 'json',
        data: datatosend,
        success: function (data) {
            $('#autopsy_importation_tool div.specimen_card').html(data);
        }
    });
};

$(document).ready(function () {
    var pk=$('#autopsy_importation_tool div.container_action input.specimenlink').val();
    if(pk != null){
        searchSpecimenUpdCard(pk);
    }
    callbackspecimenlink = function () {
        $('#autopsy_search_specimens div.observations_results tr').click(function () {
            if ($(this).attr('pk') == undefined) {
                return false;
            }
            test = $.evalJSON($(this).attr('pk'));
            if (test == undefined) {
                return false;
            }
            pk = test['Specimen ID'];
            // First, test if there is an existing specimen under autopsy
            if ($('#autopsy_importation_tool div.record_item').length != 0) {
                var answer = confirm('Are you sure you want to change the animal necropsied');
                if (!answer) {
                    return false;
                }
                searchSpecimenUpdCard(pk);

            }
            else {
                searchSpecimenUpdCard(pk);
            }
        });
    }

    options_specimen_link = {
        search_object: "Search_Spec2events_autopsies",
        perform_search: "/legacy/functions/spec2events_search_autopsies.php",
        search_results: "observations_results",
        callback_results: callbackspecimenlink
    };

    $("#autopsy_search_specimens").search(options_specimen_link);

    $(".specimenTaglink").change(function(){
        var datatosend = {};
        datatosend['specimenTagLink'] = $(this).val();
        $.ajax({
            url: '/legacy/functions/specimens_search_by_tag.php',
            type: 'POST',
            datatype: 'json',
            data: datatosend,
            success: function (data) {
                $('#autopsy_importation_tool div.specimen_card').html(data);
                var $data_id=$(data).find('.data-id');
                $('#autopsy_importation_tool div.container_action input.specimenlink').val(id);
            }
        });
    });
});