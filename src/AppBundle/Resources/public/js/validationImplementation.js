$.validator.addMethod("dateBELogical", function (value) {
    //var dt = Date.parseExact(value, ["dd/MM/yyyy"]);
    //var tomorrow = Date.today().addDays(1);
    var dt=moment(value, "DD/MM/YYYY", true);
    var tomorrow = moment().add(1, 'day');
    var valid=dt.isValid();
    return value==null || value=='' || (valid && dt.isBefore(tomorrow)); //empty values are allowed
}, '2 problems: either an invalid date (not dd/mm/yyyy) or either the date is in the future');

$.validator.addMethod('validDaterange', function(value,element) {
    var $parent=$(element).closest("#periodpicker");
    var $firstDateTextbox = $($parent.find("input")[0]);
    var $lastDateTextbox = $($parent.find("input")[1]);
    //var ds = Date.parseExact($firstDateTextbox.val(), ["dd/MM/yyyy"]);
    //var de = Date.parseExact($lastDateTextbox.val(), ["dd/MM/yyyy"]);

    var ds=moment($firstDateTextbox.val(), "DD/MM/YYYY", true);
    var de=moment($lastDateTextbox.val(), "DD/MM/YYYY", true);

    if(ds.isValid() && de.isValid()){
        return (ds.isBefore(de));
    }
    else return true;
}, 'The start date lies after the end date.');

$.validator.addMethod("validNecropsyTag", function (value) {
    return /^$|^[a-zA-Z]{2}[_][0-9]{4}[_][0-9]{1,6}$/.test(value);
}, 'Not a necropsy tag. The correct format is BE/FR_yyyy_integer, eg. BE_1996_15');


$.validator.addMethod("validLatDec", function (value,element) {
    var elClass=element.getAttribute('class');
    var re = /refer-to_(.*?)\b/;
    var othId = re.exec(elClass)[1];
    var lonDecField=$('#'+othId);
    return validCoord(value, lonDecField.val()) && validLatDec(value);
}, '2 problems: either complete longitude or either this value is not a decimal latitude (-90.0 <= x <= 90.0)');

$.validator.addMethod("validLonDec", function (value,element) {
    var elClass=element.getAttribute('class');
    var re = /refer-to_(.*?)\b/;
    var othId = re.exec(elClass)[1];
    var latDecField=$('#'+othId);
    return validCoord(latDecField.val(), value) && validLonDec(value);
}, '2 problems: either complete latitude or either this value is not a decimal longitude (-180.0 <= x <= 180.0)');

$.validator.addMethod("validStation", function (value) {
    return stationOrCoord(value, latDecField.val(), lonDecField.val());
}, 'Please provide either a valid coordinate or a station, or both');

function validateContainer($container, validator,$clientSideErrors) {
    var id=$container.attr('id');
    var $elements = $('#' + id + ' :input');
    var valid = true;
    var badId=[];
    $elements.each(function () {
        var elId = $(this).attr('id');
        if (!validator.element($('#' + elId))) {
            valid = false;
            badId.push(elId);
        }
    });
    if (!valid) {
        $clientSideErrors.html("Validation failed on the tab that is currently being edited ("+id+"): please check all fields on "+ id +" with an error message. The following elements are invalid: <br />"+badId.join("<br />"));
    }
    else{
        $clientSideErrors.html('');
        }
    return valid;
}

function createError(index, error) {
    var $element = $(error.element).closest("div");
    var $group = $(error.element).closest(".form-group");

    if(typeof $tabs !== 'undefined'){
        $tabs.not($currentTab).not($previousTab).addClass('disabled');
    }
    $element.tooltip("destroy")
        .data("title", error.message)
        .tooltip();
    $group.removeClass("has-success").addClass("has-error has-feedback");
    if ($group.find("span.glyphicon").length === 0) {
        $group.append('<span class="glyphicon glyphicon-warning-sign form-control-feedback"> </span>');
    } else {
        $group.find("span.glyphicon").removeClass("glyphicon-ok").addClass("glyphicon-warning-sign");
    }
}

function cleanError(index, element) {
    var $element = $(element).closest("div");
    var $group = $(element).closest(".form-group");
    $element.data("title", "").tooltip("destroy");

    if(typeof $tabs !== 'undefined') {
        $tabs.not($currentTab).removeClass('disabled');
    }
    $group.removeClass("has-error").addClass("has-success has-feedback");
    if ($group.find("span.glyphicon").length === 0) {
        $group.append('<span class="glyphicon glyphicon-ok form-control-feedback"> </span>');
    } else {
        $group.find("span.glyphicon").removeClass("glyphicon-warning-sign").addClass("glyphicon-ok");
    }
}

function apply_tooltip_options(element, message) {
    var options = {
        /* Using Twitter Bootstrap Defaults if no settings are given */
        animation: $(element).data('animation') || true,
        html: $(element).data('html') || false,
        placement: $(element).data('placement') || 'top',
        selector: $(element).data('animation') || false,
        title: $(element).attr('title') || message,
        trigger: $.trim('manual ' + ($(element).data('trigger') || '')),
        delay: $(element).data('delay') || 0,
        container: $(element).data('container') || false
    };
    return options;
}

function stationOrCoord(station, latDec, lonDec) {
    if (!lonDec && !latDec) {
        if (!station) {
            return false;
        }
        else return true;
    }
    else {
        if (!validCoord(latDec, lonDec)) {
            return false;
        }
        else return true; // either empty or nonempty stations
    }
}

function validCoord(latDec, lonDec) {
    if ((lonDec && !latDec) || !lonDec && latDec) {
        return false;
    }
    else return true;
}

function validLatDec(latDec) {
    return /^$|^(\+|-)?(\d\.\d{1,6}|[1-8]\d\.\d{1,6}|90\.\d{1,6})$/.test(latDec);
}

function validLonDec(lonDec) {
    return /^$|^(\+|-)?([0-9][0-9]?\.\d{1,6}|1[0-7][0-9]\.\d{1,6}|180\.\d{1,6})$/.test(lonDec);
}

