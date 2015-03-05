var RemoteSpecimen = function (scnId) {

    this.scn;
    var me=this;
    var scn;

    this.getRemoteScn = function () {
        return scn;
    };

     var getRemoteScn = function () {
        //var specimenExists;
        var scnInternal;
        /*var scnNumber;
        var sex;
        var rbinsTag;
        var mummTag;
        var species;*/
        $.ajax({
            type: "GET",
            url: "/ajax/scn/"+scnId,
            dataType: "json",
            success: function(response) {
                console.log(response);
                //specimenExists=response['found'];
                me.scn=response;
                scn=response;
                scnInternal=response;
                /*scnNumber=response['scnNumber'];
                sex=response['sex'];
                rbinsTag=response['rbinsTag'];
                mummTag=response['mummTag'];
                species=response['species'];*/
            }
        });
    };
/*
    var getRemoteScnExists = function () {
        $.ajax({
            type: "GET",
            url: "/ajax/scnexists/"+scnId,
            dataType: "json",
            success: function(response) {
                console.log(response);
                thisClass.specimenExists=response['found'];
            }
        });
    };

    var getRemoteScnNumber = function () {
        $.ajax({
            type: "GET",
            url: "/ajax/scnnumber/"+scnId,
            dataType: "json",
            success: function(response) {
                console.log(response);
                thisClass.scnNumber=response['scnNumber'];
            }
        });
    };*/

    getRemoteScn();
    //getRemoteScnExists();
/*
    this.init = function () {
        getRemoteScnExists();
        getRemoteScnNumber();
    };
    this.init();
*/
};


