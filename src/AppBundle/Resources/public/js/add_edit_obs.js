var $tabs = $('.tab');
var wholeForm = $('#observationform');
var $currentTab = $("a[href='tab-1']").parent();
var $currentPanel = $('#tab-1');
var $previousTab;
var $previousPanel;

var newSpecimenNumberField = $('#observationstype_eseSeqno_spec2events_scnSeqnoNew_scnNumber');
var fieldsAndBoxesThatAreIllegalOnMultipleSpecimens = $('.no-multi');
var fieldsAndBoxesThatAreIllegalOnMultipleSpecimens_requiredInputSelect = fieldsAndBoxesThatAreIllegalOnMultipleSpecimens.find('[required="required"]');
var $identificationCertaintyBox = $('#observationstype_eseSeqno_spec2events_scnSeqnoNew_identificationCertainty');
var stationSelector = $('#observationstype_stnSeqno');
var existingSpecimenChoiceField = $('#observationstype_eseSeqno_spec2events_scnSeqnoExisting');
var newSpecimenChoiceField = $('#observationstype_eseSeqno_spec2events_scnSeqnoNew_txnSeqno');
var newSpecimenBox = $('#new-specimen');
var newSpecimenBox_requiredInputSelect = newSpecimenBox.find('[required="required"]');
var $onlyForDeadBox = $('.only-dead');
var $onlyForDeadBox_requiredInputSelect = $onlyForDeadBox.find('[required="required"]');
var $anyFieldIndicatingDeadness = $("#observationstype_osnTypeRef, .decomposition_code, .during_intervention");
var $multipleSpecimensFeedback = $('#multipleSpecimensFeedback');
var $existingSpecimenFeedback = $('#existingSpecimenFeedback');
var $circumstantialParametersFeedback = $('#circumstantialParametersFeedback');
var $sexBox = $('#observationstype_eseSeqno_spec2events_scnSeqnoNew_sex');
var $scnInfo = $('#scnInfo');
var $dateBox = $('#observationstype_eseSeqno_eventDatetime_date');
var $eventDatetime = $('#observationstype_eseSeqno_eventDatetime_time');
var $eventDatetimeFlag = $('#observationstype_eseSeqno_eventDatetimeFlagRef');
var $pathologyValues = $("select[id*='pathologyValues']");
var $allInputSelect = $(":input, textarea");
var latDecField = $('#observationstype_latDec');
var lonDecField = $('#observationstype_lonDec');
var remoteSpecimen;
var allValues = {};
var marker;
var $submitButton = $("input[type='submit']");
var multipleSpecimens = false;
var map;
var id = function () {
    var url = window.location.href;
    var idr = new RegExp('observations\/update\/(\\d*)');
    return idr.exec(url)[1];
};

var updateKey = "current-observation-update";
var entryKey = "current-observation-entry";
localStorageDataKey = function () {
    var url = window.location.href;
    if (url.indexOf('observations/add') > -1) {
        return entryKey;
    }
    else if (url.indexOf('observations/update') > -1) {
        return updateKey + "-" + id();
    }
    else {
        return null;
    }
};


var maxlengthMsg = function (maxlength, input) {
    return [
        'Please enter no more than ',
        maxlength,
        ' characters.',
        ' You have typed ',
        $(input).val().length,
        ' characters.'
    ].join('');
};

var validator = wholeForm.validate({
    ignore: "",
    rules: {
        "observationstype[eseSeqno][eventDatetime][date]": {dateBELogical: true, required: true},
        "observationstype[eseSeqno][description]": {
            minlength: 0,
            maxlength: 1300
        },
        "observationstype[webcommentsEn]": {
            minlength: 0,
            maxlength: 500
        },
        "observationstype[webcommentsNl]": {
            minlength: 0,
            maxlength: 500
        },
        "observationstype[webcommentsFr]": {
            minlength: 0,
            maxlength: 500
        },
        "observationstype[latDec]": 'validLatDec',
        "observationstype[lonDec]": 'validLonDec',
        "observationstype[eseSeqno][spec2events][scnSeqnoExisting]": {
            digits: true,
            min: 0
        },
        "observationstype[eseSeqno][spec2events][scnSeqnoNew][scnNumber]": {
            number: true,
            min: -1,
            max: 9999
        },
        "observationstype[eseSeqno][spec2events][scnSeqnoNew][rbinsTag]": {
            minlength: 0,
            maxlength: 20
        },
        "observationstype[eseSeqno][spec2events][scnSeqnoNew][necropsyTag]": 'validNecropsyTag',
        "observationstype[eseSeqno][spec2events][scnSeqnoNew][name]": {
            minlength: 0,
            maxlength: 50
        },
        "observationstype[eseSeqno][spec2events][scnSeqnoNew][otherTag]": {
            minlength: 0,
            maxlength: 40
        },
        "observationstype[eseSeqno][spec2events][pathologyValues][38][value]": {
            minlength: 0,
            maxlength: 50
        }
    },
    messages: {
        "observationstype[eseSeqno][description]": {
            maxlength: maxlengthMsg
        },
        "observationstype[webcommentsEn]": {
            maxlength: maxlengthMsg
        },
        "observationstype[webcommentsFr]": {
            maxlength: maxlengthMsg
        },
        "observationstype[webcommentsNl]": {
            maxlength: maxlengthMsg
        }
    },
    showErrors: function (errorMap, errorList) {
        $.each(this.validElements(), cleanError);
        $.each(errorList, createError);
    }
});

var getRemoteScn = function (scnId) {
    $.ajax({
        type: "GET",
        url: "/ajax/scn/" + scnId,
        dataType: "json",
        async: false,
        success: function (response) {
            remoteSpecimen = response;
        }
    });
};

function instantiateRemoteSpecimen() {
    var scnId = existingSpecimenChoiceField.val();
    if (/^[0-9]+$/.test(scnId)) {
        getRemoteScn(scnId);
        if (typeof remoteSpecimen !== 'undefined') {
            if (remoteSpecimen.found) {
                $scnInfo.html("");
                $scnInfo.append('Seqno: ' + remoteSpecimen.seqno + '<br />');
                $scnInfo.append('Species: ' + remoteSpecimen.species + '<br />');
                $scnInfo.append('Number: ' + remoteSpecimen.scnNumber + '<br />');
                $scnInfo.append('Sex: ' + remoteSpecimen.sex + '<br />');
                $scnInfo.append('RBINS Tag: ' + remoteSpecimen.rbinsTag + '<br />');
                $scnInfo.append('Collection tag (=old MUMM Tag): ' + remoteSpecimen.collectionTag + '<br />');
            }
            else {
                $scnInfo.html("");
                $scnInfo.html('The specimen was not found');
            }
        }
    }
}

function makelist(list, $element) {
    var listElement = document.createElement("ul");
    var numberOfListItems = list.length;
    for (var i = 0; i < numberOfListItems; ++i) {
        var listItem = document.createElement("li");
        listItem.innerHTML = list[i];
        listElement.appendChild(listItem);
    }
    $element.append(listElement);
}

function initDefaults() {
    if (newSpecimenNumberField.val() === '') {
        newSpecimenNumberField.val(1);
    }
    $identificationCertaintyBox.prop('checked', true);
    var output = "";
    if (localStorageDataKey() !== null) {
        if (window.localStorage) {
            if (localStorage.length) {
                for (var i = 0; i < localStorage.length; i++) {
                    output += localStorage.key(i) + ': ' + localStorage.getItem(localStorage.key(i)) + '\n';
                    if (localStorage.key(i) == localStorageDataKey()) {
                        allValues = JSON.parse(localStorage.getItem(localStorage.key(i)));
                    }
                }
            } else {
                output += 'There is no data stored for this domain.';
            }
        } else {
            output += 'Your browser does not support local storage.'
        }
        console.log("localStorage: " + output);

        for (var prop in allValues) {
            var id = "#" + prop;
            var $id = $(id);
            makeAssociatedFlagRequired($id, validator);
            if (allValues.hasOwnProperty(prop)) {
                if (document.getElementById("" + prop)) {
                    var val = allValues[prop];
                    if ($id.attr('type') == 'checkbox') {
                        $id.prop("checked", val)
                    }
                    else {
                        $id.val(val);
                        $id.trigger("change");
                    }
                }
            }
        }
    }
}

var initCharCountLimit = function ($element) {
    var maxLength = $element.rules().maxlength;
    var charCountClass = $element.attr('id') + "-charcount";
    $element.after("<p class='" + charCountClass + "'></p>");

    countChar($element.get(0), maxLength, '.' + charCountClass); //show inital value on page load
    $element.keyup(function () {
        countChar(this, maxLength, '.' + charCountClass); //set up on keyup event function
    });
};

function countChar(inobj, maxl, outobj) {
    var len = inobj.value.length;
    var msg = '/' + maxl;
    if (len >= maxl) {
        //inobj.value = inobj.value.substring(0, maxl);
        //$(outobj).text(0 + msg);
        $(outobj).text(maxl - len + msg);
        $(outobj).addClass('has-error');
    } else {
        $(outobj).text(maxl - len + msg);
        $(outobj).removeClass('has-error');
    }
}

(function ($) {
    $.fn.isAfter = function (sel) {
        return this.prevAll().filter(sel).length !== 0;
    };

    $.fn.isBefore = function (sel) {
        return this.nextAll().filter(sel).length !== 0;
    };
})(jQuery);

function hideFieldsAndBoxesThatAreIllegalOnMultipleSpecimens() {
    var remoteScnNumber = null;
    if (remoteSpecimen !== null) {
        if (typeof remoteSpecimen !== 'undefined') {
            if (remoteSpecimen.found) {
                remoteScnNumber = remoteSpecimen.scnNumber;
            }
        }
    }
    if (isMultipleSpecimens()) {

        multipleSpecimens = true;
        fieldsAndBoxesThatAreIllegalOnMultipleSpecimens.find('input').val('');
        fieldsAndBoxesThatAreIllegalOnMultipleSpecimens.find('select').prop('selectedIndex', 0);
        fieldsAndBoxesThatAreIllegalOnMultipleSpecimens.find('input[checked]').removeAttr('checked');
        fieldsAndBoxesThatAreIllegalOnMultipleSpecimens_requiredInputSelect.removeAttr('required');
        $sexBox.removeAttr('required');
        fieldsAndBoxesThatAreIllegalOnMultipleSpecimens.hide();
        $multipleSpecimensFeedback.show();
        return false;
    }
    if (!isMultipleSpecimens()) {
        if (remoteScnNumber === null) {
            fieldsAndBoxesThatAreIllegalOnMultipleSpecimens_requiredInputSelect.attr('required', 'required');
            $sexBox.attr('required', 'required');
        }
        fieldsAndBoxesThatAreIllegalOnMultipleSpecimens.show();
        $multipleSpecimensFeedback.hide();
        $pathologyValues.prop('selectedIndex', 2);
        return false;
    }
}

function isMultipleSpecimens() {
    var scnNumber = parseInt(newSpecimenNumberField.val());
    var remoteScnNumber = null;
    if (remoteSpecimen !== null) {
        if (typeof remoteSpecimen !== 'undefined') {
            if (remoteSpecimen.found) {
                remoteScnNumber = remoteSpecimen.scnNumber;
            }
        }
    }
    if (scnNumber > 1 || remoteScnNumber > 1) {
        return true;
    }
    else if (scnNumber < 2) {
        return false;
    }
}

function hideFieldsAndBoxesThatAreIllegalOnExistingSpecimen() {
    var scnId = existingSpecimenChoiceField.val();
    var newSpecimenBox_allInput = newSpecimenBox.find('input');
    var newSpecimenBox_allSelect = newSpecimenBox.find('select');
    var childs = newSpecimenBox.children();
    if (/^[0-9]+$/.test(scnId)) {
        $(this).attr('required', 'required');
        newSpecimenBox_requiredInputSelect.removeAttr('required');
        newSpecimenBox_requiredInputSelect.each(function () {
            $(this).removeAttr('required')
        });
        $sexBox.removeAttr('required');
        newSpecimenBox_allInput.val('');
        newSpecimenBox_allSelect.prop('selectedIndex', 0);
        newSpecimenBox.hide();
        $existingSpecimenFeedback.show();
        return false;
    }
    if (scnId === '') {
        remoteSpecimen = null;
        //newSpecimenBox_requiredInputSelect.attr('required', 'required');
        //$sexBox.attr('required', 'required');
        newSpecimenBox.show();
        childs.show();
        if (isMultipleSpecimens() === false) {
            childs.show();
            newSpecimenBox_requiredInputSelect.attr('required', 'required');
        }
        else {
            childs.not('.no-multi').show();
            //newSpecimenBox_requiredInputSelect.not('.no-multi').attr('required', 'required');
        }
        $existingSpecimenFeedback.hide();
        $circumstantialParametersFeedback.hide();
        $scnInfo.html("");
        return false;
    }
}

function hideFieldsAndBoxesThatAreIllegalOnAliveSpecimens() {
    var scnNumber = newSpecimenNumberField.val();
    if (animalIsAliveDuringOrAfterIntervention()) {
        $onlyForDeadBox_requiredInputSelect.removeAttr('required');
        $onlyForDeadBox.hide();
    }
    else if (scnNumber < 2) {
        $onlyForDeadBox_requiredInputSelect.attr('required', 'required');
        $onlyForDeadBox.show();
    }
}

function makeAssociatedFlagRequired($element, validator) {
    var id = $element.attr('id');
    if (id) {

    }
    var $associatedFlag = $("." + id + "FlagRef");//in some cases class is used; reason see add-observations.html.twig; precisionFlag is the actual id instead of lonDecFlag.

    if (!$associatedFlag.length) {
        $associatedFlag = $("#" + id + "FlagRef");
    }
    if (!$associatedFlag.length && ($element.is(latDecField) || $element.is(lonDecField))) {
        $associatedFlag = $("#observationstype_precisionFlag");
    }
    if ($associatedFlag.length) {
        var value = $element.val();
        if (value != '') {
            $associatedFlag.attr('required', 'required');
        }
        else {
            $associatedFlag.removeAttr('required');
        }
        validator.element($associatedFlag.selector);
    }
}

function animalIsAliveDuringOrAfterIntervention() {
    var decompositionCode = parseInt($('.decomposition_code :selected').text());
    var osnType = $('#observationstype_osnTypeRef :selected').text();
    var duringIntervention = $('.during_intervention :selected').text();

    var deadOsnTypes = ["Found dead in Harbour", "Died during transport/rehab", "Found dead on beach", "Found dead at Sea"];
    var deadDuringInterventionTypes = ["died during intervention/rehab same day", "euthanized"];

    var deadByOsnType = true;
    deadByOsnType = ($.inArray(osnType, deadOsnTypes) != -1);
    var deadByDuringInterventionType = true;
    deadByDuringInterventionType = ($.inArray(duringIntervention, deadDuringInterventionTypes) != -1);
    var dead = (deadByDuringInterventionType || deadByOsnType || decompositionCode > 1);
    return !dead;
}

function initialize() {
    var canvas = document.getElementById('map-canvas');
    if (canvas) {
        var lat = (!latDecField.val()) ? Number(canvas.getAttribute('data-lat')) : Number(latDecField.val());
        var lng = (!lonDecField.val()) ? Number(canvas.getAttribute('data-lon')) : Number(lonDecField.val());
        var myLatlng = {lat: lat, lng: lng};

        var mapOptions = {
            center: myLatlng,
            zoom: 10,
            streetViewControl: false
        };
        map = new google.maps.Map(canvas, mapOptions);

        if (latDecField.val() && lonDecField.val()) {
            marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                title: 'x=' + lng + '; y=' + lat
            });
            marker.addListener('click', function () {
                map.setZoom(14);
                map.setCenter(marker.getPosition());
            });
        }

        map.addListener('click', function (event) {
            var lat = round(event.latLng.lat(), 6);
            var lng = round(event.latLng.lng(), 6);
            //var lat = event.latLng.lat();
            //var lng = event.latLng.lng();
            if (marker != null) {
                marker.setMap(null);
                marker = null;
            }
            marker = new google.maps.Marker({
                position: {lat: lat, lng: lng},
                map: map,
                title: 'Observation'
            });
            marker.addListener('click', function () {
                map.setZoom(14);
                map.setCenter(marker.getPosition());
            });
            latDecField.val(lat);
            //makeAssociatedFlagRequired(latDecField, validator);
            latDecField.trigger("change");
            lonDecField.val(lng);
            //makeAssociatedFlagRequired(lonDecField, validator);
            lonDecField.trigger("change");
        });


    }
}

function round(value, decimals) {
    return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals);
}

function coordDiff(coord1, coord2) {
    return coord1.lat != coord2.lat || coord1.lon != coord2.lon;
}

$(document).ready(function () {
    google.maps.event.addDomListener(window, 'load', initialize);
    $('.help-block').closest('div').not('.has-error').attr('class', 'has-error');
    $tabs.not($currentTab).not($previousTab).addClass('disabled');
    //$('#formsuccess').delay(200000).hide();
    initDefaults();
    instantiateRemoteSpecimen();
    hideFieldsAndBoxesThatAreIllegalOnMultipleSpecimens();
    hideFieldsAndBoxesThatAreIllegalOnExistingSpecimen();
    hideFieldsAndBoxesThatAreIllegalOnAliveSpecimens();


    $("#observationform").easytabs({
        tabs: ".nav-tabs li",
        animate: false,
        tabActiveClass: "active"
    }).bind('easytabs:before', function (evt, destTab, destPanel, data) {
        $currentTab = $(this).find('li.active');
        $currentPanel = $(this).find('fieldset.active');
        var goBack = destTab.parent().isBefore($currentTab); //destTab is actually the anchor
        var $clientSideErrors = $('#formerror_clientside');
        var valid = validateContainer($currentPanel, validator, $clientSideErrors);

        if (valid) {
            $clientSideErrors.html = '';
            $previousTab = $currentTab;
            $previousPanel = $currentPanel;
            $currentTab = destTab;
            $currentPanel = destPanel;
        }
        return valid || goBack;
    });
    stationSelector.select2();
    newSpecimenChoiceField.select2({
        dropdownAutoWidth: true,
        containerCss: {"display": "block"}
    });
    $('[data-tooltip!=""]').qtip({
        content: {
            attr: 'data-tooltip'
        }
    });
    var options = {
        dateFormat: 'dd/mm/yy',
        showButtonPanel: true,
        changeMonth: true,
        changeYear: true,
        minDate: new Date(1950, 1 - 1, 1)
    };
    $dateBox.datepicker(options);//.datepicker("setDate", Date.today());

    $('.subformcontainer').next('.form-group').remove();

    $('.prev-tab').click(function () {
        var currTab;
        currTab = $('a.active').attr('href');
        var i = ( parseInt(currTab.match(/\d+/)) - 2 );
        $tabs.children('a:eq(' + i + ')').click();
    });

    $('.next-tab').click(function () {
        var currTab;
        currTab = $('a.active').attr('href');
        var i = ( parseInt(currTab.match(/\d+/)) );
        $tabs.children('a:eq(' + i + ')').click();
    });

    $allInputSelect.keypress(function (evt) {
        var keycode = evt.charCode || evt.keyCode;
        if (keycode == 13) { //Enter key's keycode
            return false;
        }
    });

    $submitButton.click(function () {
        localStorage.clear();
    });

    $allInputSelect.change(function () {
        if ($(this).attr('type') == 'checkbox') {
            var val = $(this).prop("checked");
        }
        else {
            val = $(this).val();
        }
        allValues[$(this).attr('id')] = val;
        if (localStorageDataKey() != null) {
            localStorage.setItem(localStorageDataKey(), JSON.stringify(allValues));
        }
    });

    var $specimenModalDiv = $('div#specimen-searcher-modal');

    var dialog = $specimenModalDiv.dialog({
        autoOpen: false,
        modal: true,
        draggable: false,
        open: function () {
            if ($(this).html().length == 0) {
                $(this).load('/ajax/observed-specimens', function () {
                    //var $specimenSearcher = $('div#specimen-searcher');
                    var $specimenModalContent = $specimenModalDiv.find('.modal-content');
                    var $observationfilterform = $('form#observationfilterform');
                    //var $as = $('ul.pagination a');
                    //var aIdent='ul.pagination a';
                    var ap = Object.create(AsyncPostNClick);
                    ap.formIdentifier = 'form#observationfilterform';
                    ap.linkIdentifier = 'ul.pagination a';
                    ap.myselfIdentifier = 'div#specimen-searcher';
                    ap.additionalFunction.push(function () {
                        $("#specimen-searcher #observationstable tbody tr").click(function () {
                            if (typeof($clickedRow) !== 'undefined') {
                                $clickedRow.removeClass('selected');
                            }
                            $clickedRow = $(this);
                            $(this).addClass('selected');
                            var seqno = $(this).find('td.seqno').html();
                            var $seqnoField = $('input#observationstype_eseSeqno_spec2events_scnSeqnoExisting');
                            //('div#specimen-searcher-modal').trigger('seqno_selected',seqno); //doesn't work unfortunately
                            $seqnoField.val(seqno).trigger('change');
                        });
                    });
                    ap.allowAsyncSubmit();
                    ap.allowAsyncLinks();
                });
            }

        },
        height: 800,
        width: 1400,
        title: 'Search a specimen'
    });

    $('button#b_search_scn').click(function (e) {
        dialog.dialog('open');
        e.preventDefault();
        return false;
    });


    //  if ($('.radio label')[0].childNodes[0].nodeValue = 'unknown') {
    //      $(this).find('input[checked]').attr('checked', 'checked');
    //  }
    //  $('.no-multi').find('input[checked]').removeAttr('checked');


    var allNonRequiredInputSelectValues = $("select[id$='value'],input[id$='value']").not("[required='required']");

    existingSpecimenChoiceField.change(function () {
        instantiateRemoteSpecimen();
        hideFieldsAndBoxesThatAreIllegalOnExistingSpecimen();
        //newSpecimenBox_requiredInputSelect.attr('required', 'required');
        hideFieldsAndBoxesThatAreIllegalOnMultipleSpecimens();
    });

    newSpecimenChoiceField.change(function () {
        var value = $(this).val();
        if (value != '') {
            existingSpecimenChoiceField.removeAttr('required').val('');
        }
        else {
            existingSpecimenChoiceField.attr('required', 'required');
        }
        return false;
    });
    newSpecimenNumberField.change(function () {
        hideFieldsAndBoxesThatAreIllegalOnMultipleSpecimens();
    });


    latDecField.change(function () {
            /*var latField = $(this).val();
            var lngField = lonDecField.val();
            if (latField != null && lngField != null) {
                var posField = {lat: latField, lng: lngField};
            }
            if (marker != null) {
                var posMap = marker.position;
                marker.setMap(null);
                marker = null;
            }
            if (posField != null && (marker === null || coordDiff(posField, posMap))) {
                if (marker != null) {
                    marker.setMap(null);
                    marker = null;
                }
                marker = new google.maps.Marker({
                    position: posField,
                    map: map,
                    title: 'x=' + posField.lng + '; y=' + posField.lat
                });
                marker.addListener('click', function () {
                    map.setZoom(14);
                    map.setCenter(marker.getPosition());
                });
            }*/
            makeAssociatedFlagRequired($(this), validator);
        }
    );

    lonDecField.change(function () {
            /*var lngField = $(this).val();
            var latField = latDecField.val();
            if (latField != null && lngField != null) {
                var posField = {lat: latField, lng: lngField};
            }
            if (marker != null) {
                var posMap = marker.position;
                marker.setMap(null);
                marker = null;
            }
            if (posField != null && (marker === null || coordDiff(posField, posMap))) {
                if (marker != null) {
                    marker.setMap(null);
                    marker = null;
                }
                marker = new google.maps.Marker({
                    position: posField,
                    map: map,
                    title: 'x=' + posField.lng + '; y=' + posField.lat
                });
                marker.addListener('click', function () {
                    map.setZoom(14);
                    map.setCenter(marker.getPosition());
                });
            }*/
            makeAssociatedFlagRequired($(this), validator);
        }
    );

    allNonRequiredInputSelectValues.change(function () {
            makeAssociatedFlagRequired($(this), validator);
        }
    );

    $anyFieldIndicatingDeadness.change(function () {
        hideFieldsAndBoxesThatAreIllegalOnAliveSpecimens();
    });

    $eventDatetimeFlag.change(function () {
        var flagVal = $('#observationstype_eseSeqno_eventDatetimeFlagRef :selected').text();
        if (flagVal === "time unknown") {
            $eventDatetime.val('12:00');
            $eventDatetime.change();
        }
    });

    var sfp1 = new SymfonyPrototype($('ul.e2p_observer'), $('<a href="#" id="add_observer">Add an observer</a>'), '__observers_name__');
    sfp1.addAddLink();
    var sfp2 = new SymfonyPrototype($('ul.e2p_collector'), $('<a href="#" id="add_collector">Add a collector</a>'), '__collectors_name__');
    sfp2.addAddLink();
    var sfp2 = new SymfonyPrototype($('ul.e2p_informer'), $('<a href="#" id="add_informer">Add an informer</a>'), '__informers_name__');
    sfp2.addAddLink();
    var sfp2 = new SymfonyPrototype($('ul.e2p_examiner'), $('<a href="#" id="add_examiner">Add an examiner</a>'), '__examiners_name__');
    sfp2.addAddLink();


    wholeForm.find('a.initially-disabled').removeClass('initially-disabled');

    initCharCountLimit($('#observationstype_eseSeqno_description'));
    initCharCountLimit($('#observationstype_webcommentsEn'));
    initCharCountLimit($('#observationstype_webcommentsFr'));
    initCharCountLimit($('#observationstype_webcommentsNl'));
});
