var $seqnoField = $('input#observationstype_eseSeqno_spec2events_scnSeqnoExisting');
var $myself = $('div#specimen-searcher');
var $as;
var $clickedRow;
var $modal;

var postForm = function ($form, callback) {
    var values = {};
    $.each($form.serializeArray(), function (i, field) {
        values[field.name] = field.value;
    });
    $.ajax({
        type: $form.attr('method'),
        url: $form.attr('action'),
        data: values,
        evalScripts: true,
        success: function (data) {
            callback(data);
        }
    });
};

var initAsyncLayout = function ($form) {
    var $loadIcon = $('span#loading');
    if ($loadIcon.length === 0) {
        $form.append("<span id='loading' class='fa fa-spinner'></span>");
        $loadIcon = $('span#loading');
        $loadIcon.hide();
    }
    $("#specimen-searcher #observationstable tbody tr").click(function () {
        if (typeof($clickedRow) !== 'undefined') {
            $clickedRow.removeClass('selected');
        }
        $clickedRow = $(this);
        $(this).addClass('selected');
        var seqno = $(this).find('td.seqno').html();
        //('div#specimen-searcher-modal').trigger('seqno_selected',seqno); //doesn't work unfortunately
        $seqnoField.val(seqno).trigger('change');
    });

    $(document)
        .ajaxStart(function () {
            //$myself.addClass('ui-widget-overlay');
            $form.find(':input').attr('disabled', true);
            //$loadIcon.show();
        })
        .ajaxStop(function () {
            //$myself.removeClass('ui-widget-overlay');
            $form.attr('disabled', false);
            //$loadIcon.hide();
        });
};

var allowAsyncSubmit = function ($myself, $form, callback) {
    initAsyncLayout($form);
    $form.submit(function (e) {
        e.preventDefault();
        postForm($(this), function (response) {
            $myself.html(response);
            //callback();
            var $form = $('form#observationfilterform');
            allowAsyncSubmit($myself, $form, callback);
            $as = $('ul.pagination a');
            allowAsyncLinks($myself, $as);
        });
        return false;
    });
};

var allowAsyncLink = function ($myself, $a) {
    initAsyncLayout($form);
    $a.click(function (e) {
        console.log($a);
        e.preventDefault();
        $.ajax({
            //type: $form.attr('method'),
            url: $a[0].href,
            evalScripts: true,
            success: function (response) {
                $myself.html(response);
                $as = $('ul.pagination a');
                allowAsyncLinks($myself, $as);
            }
        });
    });
};

var allowAsyncLinks = function ($myself, $as) {
    $as.each(function (i, e) {
        var $a=$($as[i]);
                allowAsyncLink($myself, $a);
    });
};

$(document).ready(function () {
    var $form = $('form#observationfilterform');
    $modal = $($myself.parents(".modal")[0]);
    allowAsyncSubmit($myself, $form);
    $as = $('ul.pagination a');
    allowAsyncLinks($myself, $as);
});
