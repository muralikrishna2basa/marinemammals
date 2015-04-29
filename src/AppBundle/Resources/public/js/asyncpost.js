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



var initAsyncLayout=function(){
    var $loadIcon = $('span#loading')
    if ($loadIcon[0] === null) {
        $(document).append("<span id='loading' class='fa fa-spinner'></span>");
        $loadIcon.hide();
    }

    $(document)
        .ajaxStart(function () {
            //$myself.addClass('ui-widget-overlay');
            $form.find(':input').attr('disabled', true);
            $loadIcon.show();
        })
        .ajaxStop(function () {
            //$myself.removeClass('ui-widget-overlay');
            $form.attr('disabled', false);
            $loadIcon.hide();
        });
};

var allowAsyncSubmit = function ($myself, $form, callback) {
    initAsyncLayout();
    $form.submit(function (e) {
        e.preventDefault();
        postForm($(this), function (response) {
            $myself.html(response);
            callback();
            allowAsyncSubmit();
        });
        return false;
    });
};

var allowAsyncLink = function ($target, $a) {
    initAsyncLayout();
    $a.click(function() {
        $.ajax({
            //type: $form.attr('method'),
            url: $a.href,
            data: values,
            evalScripts: true,
            success: function (data) {
                callback(data);
            }
        });
    });
};

$(document).ready(function () {
    var $myself = $('div#specimen-searcher');
    var $form = $('form#observationfilterform');
    var $modal=$($myself.parents(".modal")[0]);
    //var data=$modal.data('callback');
    allowAsyncSubmit($myself, $form);
    //allowAsyncLink($target, $a);
    //var $seqnoField=$('input#observationstype_eseSeqno_spec2events_scnSeqnoExisting');

    $("#specimen-searcher #observationstable tr[role='row']").click(function(){
        var seqno=$(this).find('td.seqno').html();
        //('div#specimen-searcher-modal').trigger('seqno_selected',seqno); //doesn't work unfortunately
        var $seqnoField = $('input#observationstype_eseSeqno_spec2events_scnSeqnoExisting');
        $seqnoField.val(seqno);
    });
});
