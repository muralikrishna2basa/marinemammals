var $selectSample = $('.select-sample');
var $requests = $('#requestloanstype_speSeqno');

var $sampleTable = $('.table-samples');
var requestLoan = {samples:[]};
var $requestsArray = $.parseJSON($requests.val());
var $studyDescription=$('requestloanstype_studyDescription');
var $p2rType=$('requestloanstype_user2Requests_p2rType');
var ck = Object.create(Cookies);

var refreshRequests=function(){
    $('#edit-requests').empty();
    $('#edit-requests').load('/samples/biobank/requests/viewcurrent');
};

$(document).ready(function () {

    /*$sampleTable.on("mouseenter", "li", function(){

     $(this).text("Click me!");

     });*/

    $studyDescription.on("change", function () {
        var studyDescription=$(this).val();
        if(studyDescription !== requestLoan.studyDescription){
            requestLoan.studyDescription=studyDescription;
        }
        ck.setItem('current-samples-request', JSON.stringify(requestLoan));
        refreshRequests();
    });

    $p2rType.on("change", function () {
        var p2rType=$(this).val();
        if(p2rType !== requestLoan.p2rType){
            requestLoan.p2rType=p2rType;
        }
        ck.setItem('current-samples-request', JSON.stringify(requestLoan));
        refreshRequests();
    });

    $sampleTable.on("click", ".select-sample", function () {
        var seqno = Number($(this).attr('data-seqno'));
        var headRow = $(this).parents('tbody').siblings('thead').find('tr')[0];
        var row = $(this).parents('tr')[0];

        if ($(this).prop('checked')) {
            //$requestsArray.push($seqno);

            var sample = {};
            for (var j = 0, col; col = row.cells[j]; j++) {
                sample[headRow.cells[j].innerHTML.replace(' ','_')] = col.innerHTML;
            }
            var fullSpeciesName=sample.species;//bay porpoise (<i>Phocoena phocoena</i>)
            //var ii=fullSpeciesName.indexOf('<');
            //var scientificName=fullSpeciesName.substr(ii-1,fullSpeciesName.length);

            var scr=new RegExp('<i>(.*|\n)?<\/i>');
            var ver=new RegExp('(^.*) [(]');
            sample.scientificName = scr.exec(fullSpeciesName)[1];
            sample.vernacularName = ver.exec(fullSpeciesName)[1];
            sample.timestampAdded = Date.now();

            delete sample.select; //delete the property select which is just the select button html

            //requestLoan.samples[seqno]=sample;
            requestLoan.samples.push(sample);
        }
        else {
            // do what you need here
            var index = $requestsArray.indexOf(seqno); //seqnos are unique in the array
            if (index > -1) {
                $requestsArray.splice(index, 1);
            }
            delete requestLoan.samples[seqno];
        }
        //$requests.val(JSON.stringify($requestsArray));
        //ck.setItem('current-samples', JSON.stringify($requestsArray))
        var json=JSON.stringify(requestLoan);
        ck.setItem('current-samples-request', json);
        refreshRequests();
        //document.location.reload(true);
    });
});





