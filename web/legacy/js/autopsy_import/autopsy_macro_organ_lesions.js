$(document).ready(function () {

    // execute organ_select.js
    var fileref = document.createElement('script')
    fileref.setAttribute("type", "text/javascript")
    fileref.setAttribute("src", "js/organ_select.js")
    document.getElementsByTagName("head")[0].appendChild(fileref);

    $('button.addlesion').click(function () {
        $('table.diagnosis tr.init').clone(true).removeClass('init').show().appendTo('table.diagnosis tbody');
    });

    $('button.dellesion').click(function (e) {
        var answer = confirm('Are you sure you want to delete this lesion ( all samples attached will be removed)?');
        if (!answer) {
            return false;
        }
        $(e.target).parents('tr:first').remove();
    });

    var getDatasDiagnosis = function (form) {
        var datatosend = {};
        $(form).find('input:not(.diagnosis),select,textarea').each(function () {
            if (this.tagName == 'SELECT') {
                selected = $(this).find('option:selected');
                if (selected.length != 0) {
                    name = $(this).attr('class').split(' ')[0];
                    value = selected.val();
                    datatosend[name] = value;
                }
            }
            if (this.tagName == 'INPUT' || this.tagName == 'TEXTAREA') {
                name_input = $(this).attr('class');
                if (name_input.indexOf("[]") != -1) // take the arrays into account
                {
                    if (name_input in datatosend) {
                        datatosend[name_input].push(this.value);
                    }
                    else {
                        datatosend[name_input] = new Array(this.value);
                    }
                }
                else {
                    datatosend[name_input] = this.value;
                }
            }
        });
        return datatosend;
    }

    $('.process, .organ').change(function(){
        if($(this).parents('td').siblings('.has-sample').html()==='1'){
            alert("This organ lesion has a sample, and you have changed either its organ or the process. Please update the sample as well if needed.");
        }
    });

    $('table.diagnosis tr').change(function () {

        datatosend = getDatasDiagnosis(this);

        //  console.log($(this).find('input.diagnosis'));

        if ($(this).find('input.diagnosis').val().length != 0) {
            oldinput = $.evalJSON($(this).find('input.diagnosis').val());
            organ = oldinput['organ'];
            process = oldinput['Process'];

            if ($(this).hasClass('registered')) {
                datatosend['UPD'] = organ + "/" + process;
            }
        }
        $(this).find('input.diagnosis').val($.toJSON(datatosend));

        //   alert($.toJSON(datatosend));
    });
});