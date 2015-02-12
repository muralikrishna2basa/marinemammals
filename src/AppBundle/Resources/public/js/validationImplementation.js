$.validator.addMethod("dateBE&Logical", function (value) {
    var dt = Date.parseExact(value, ["dd/MM/yyyy"]);
    var tomorrow = Date.today().addDays(1);
    return dt != null && Date.today().isBefore(tomorrow);
}, 'Not a valid date. The correct date format is dd/mm/yyyy');

$.validator.addMethod('validDaterange', function(element) {
    var $firstDateTextbox = element.find("input:first-of-type");
    var $lastDateTextbox = element.find("input:last-of-type");
    var ds = Date.parseExact($firstDateTextbox.val(), ["dd/MM/yyyy"]);
    var de = Date.parseExact($lastDateTextbox.val(), ["dd/MM/yyyy"]);
    return (ds <= de);
});

$.validator.addMethod("validNecropsyTag", function (value) {
    return /^$|^[a-zA-Z]{2}[_][0-9]{4}[_][0-9]{1,6}$/.test(value);
}, 'Not a necropsy tag. The correct format is BE/FR_yyyy_integer, eg. BE_1996_15');

$.validator.addMethod("validLatDec", function (value) {
    return validCoord(value, lonDecField.val()) && validLatDec(value);
}, '2 problems: either complete longitude or this value is not a decimal latitude (-90.0 <= x <= 90.0)');

$.validator.addMethod("validLonDec", function (value) {
    return validCoord(latDecField.val(), value) && validLonDec(value);
}, '2 problems: either complete latitude or this value is not a decimal longitude (-180.0 <= x <= 180.0)');

$.validator.addMethod("validStation", function (value) {
    return stationOrCoord(value, latDecField.val(), lonDecField.val());
}, 'Please provide either a valid coordinate or a station, or both');

function validateContainer($container, validator) {
    var $elements = $('#' + $container.attr('id') + ' :input');
    var valid = true;
    $elements.each(function () {
        var id = $(this).attr('id');
        if (!validator.element($('#' + id))) {
            valid = false;
        }
    });
    if (!valid) {
        $('#formerror').html("There is a problem with your submission. Please check all fields of this tab for error icons.");
    }
    return valid;
}

function createError(index, error) {
    var $element = $(error.element).closest("div");
    var $group = $(error.element).closest(".form-group");

    $tabs.not($currentTab).not($previousTab).addClass('disabled');

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

    $tabs.not($currentTab).removeClass('disabled');

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

