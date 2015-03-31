$(document).ready(function () {
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
            var datatosend = {};
            datatosend['specimen_link'] = pk;
            // First, test if there is an existing specimen under autopsy
            if ($('#autopsy_importation_tool div.record_item').length != 0) {
                var answer = confirm('Are you sure you want to change the animal necropsied');

                if (!answer) {
                    return false;
                }

                $('#autopsy_importation_tool div.container_action input.specimenlink').val(pk);

                $.ajax({
                    url: 'functions/autopsy_specimen_link.php',
                    type: 'POST',
                    datatype: 'json',
                    data: datatosend,
                    success: function (data) {
                        $('#autopsy_importation_tool div.specimen_card').html(data);
                    }
                });
            }
            else {
                $('#autopsy_importation_tool div.container_action input.specimenlink').val(pk);

                $.ajax({
                    url: 'functions/autopsy_specimen_link.php',
                    type: 'POST',
                    datatype: 'json',
                    data: datatosend,
                    success: function (data) {
                        $('#autopsy_importation_tool div.specimen_card').html(data);
                    }
                });
            }
        });
    }


    options_specimen_link = {
        search_object: "Search_Spec2events",
        perform_search: "functions/spec2events_search.php",
        search_results: "observations_results",
        callback_results: callbackspecimenlink
    };

    $("#autopsy_search_specimens").search(options_specimen_link);
});