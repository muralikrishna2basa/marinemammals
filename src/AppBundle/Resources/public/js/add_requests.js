var $selectSample = $('.select-sample');
var $requests= $('#requestloanstype_speSeqno');

var $sampleTable = $('.table-sample');


$(document).ready(function () {

    /*$sampleTable.on("mouseenter", "li", function(){

        $(this).text("Click me!");

    });*/

    $sampleTable.on("click", ".select-sample", function() {
        var $seqno=Number($(this).attr('data-seqno'));
        var $requestsArray=$.parseJSON($requests.val());

        if ($(this).prop('checked')) {
            $requestsArray.push($seqno);

        }
        else {
            // do what you need here
            var index = $requestsArray.indexOf($seqno); //seqnos are unique in the array
            if (index > -1) {
                $requestsArray.splice(index, 1);
            }
        }
        //$requests.val(JSON.stringify($requestsArray));
        ck.setItem('current-samples', JSON.stringify($requestsArray))
    });

});





