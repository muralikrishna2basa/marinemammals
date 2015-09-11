var $selectSample = $('.select-sample');
//var $requests = $('#requestloanstype_speSeqno');
var $form = $('form');
var $sampleTable = $('.table-samples');
var requestLoan = {};
//var $requestsArray = $.parseJSON($requests.val());
var $studyDescription = $('requestloanstype_studyDescription');
var $p2rType = $('requestloanstype_user2Requests_p2rType');
var ck = Object.create(Cookies);

var $submitButton = $("input[type='submit']");
var localStorageDataKey = 'current-samples-request';

var refreshRequests = function () {
    $('#edit-requests').empty();
    $('#edit-requests').load('/samples/biobank/requests/viewcurrent');
};

$(document).ready(function () {
    var $sticky = $('.sticky');
    if ($sticky.length > 0) {
        var stickyTop = $sticky.offset().top;
        $(window).scroll(function () {
            var windowTop = $(window).scrollTop(); // returns number
            if (stickyTop < windowTop) {
                $sticky.css({position: 'fixed', top: 0, width: 340});
            }
            else {
                $sticky.css('position', 'static');
            }
        });
    }

    requestLoan = JSON.parse(ck.getItem(localStorageDataKey));
    if (requestLoan === null) {
        requestLoan = {samples: []};
    }
    //var seqnos={};
    if (requestLoan !== null) {
        for (i = 0; i < requestLoan.samples.length; ++i) {
            //console.log(a[index]);
            var sample = requestLoan.samples[i];
            var seqno = sample.seqno;
            //seqnos.push(requestLoan.samples[i].seqno);
            $selectSample.each(function () {
                if ($(this).attr('id').indexOf(seqno) > -1)
                    $(this).prop('checked', true);
            });
        }
    }
    /*$sampleTable.on("mouseenter", "li", function(){

     $(this).text("Click me!");

     });*/


    $submitButton.click(function () {
        //ck.removeItem(localStorageDataKey);
    });

    $studyDescription.on("change", function () {
        var studyDescription = $(this).val();
        if (studyDescription !== requestLoan.studyDescription) {
            requestLoan.studyDescription = studyDescription;
        }
        ck.setItem(localStorageDataKey, JSON.stringify(requestLoan));

        refreshRequests();
    });

    $p2rType.on("change", function () {
        var p2rType = $(this).val();
        if (p2rType !== requestLoan.p2rType) {
            requestLoan.p2rType = p2rType;
        }
        ck.setItem(localStorageDataKey, JSON.stringify(requestLoan));
        refreshRequests();
    });

    $sampleTable.unbind('click').on("click", ".select-sample", function () {
        var seqno = Number($(this).attr('data-seqno'));
        var headRow = $(this).parents('tbody').siblings('thead').find('tr')[0];
        var row = $(this).parents('tr')[0];

        if ($(this).prop('checked')) {
            //$requestsArray.push($seqno);

            var sample = {};
            for (var j = 0, col; col = row.cells[j]; j++) {
                sample[headRow.cells[j].innerHTML.replace(' ', '_')] = col.innerHTML;
            }
            var fullSpeciesName = sample.species;//bay porpoise (<i>Phocoena phocoena</i>)
            //var ii=fullSpeciesName.indexOf('<');
            //var scientificName=fullSpeciesName.substr(ii-1,fullSpeciesName.length);

            var scr = new RegExp('<i>(.*|\n)?<\/i>');
            var ver = new RegExp('(^.*) [(]');
            sample.scientificName = scr.exec(fullSpeciesName)[1];
            sample.vernacularName = ver.exec(fullSpeciesName)[1];
            sample.timestampAdded = Date.now();

            sample.seqno = seqno
            //var select=sample.select; //delete the property select which is just the select button html

            //requestLoan.samples[seqno]=sample;
            requestLoan.samples.push(sample);
        }
        else {
            // do what you need here
            /*var index = $requestsArray.indexOf(seqno); //seqnos are unique in the array
            if (index > -1) {
                $requestsArray.splice(index, 1);
            }*/
            delete requestLoan.samples[seqno];
        }
        //$requests.val(JSON.stringify($requestsArray));
        //ck.setItem('current-samples', JSON.stringify($requestsArray))
        var json = JSON.stringify(requestLoan);
        ck.setItem(localStorageDataKey, json);
        refreshRequests();
        //document.location.reload(true);
    });

    $form.unbind('change').on("change", "#limit, #page",
        function () {
            if ($(this).attr('id') === 'limit') {
                $('.limit').val($(this).val());
            }
            else {
                $('.page').val($(this).val());
            }
            $(this).closest('form').trigger('submit');
        });
});





