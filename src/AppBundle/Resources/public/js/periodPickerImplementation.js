
(function ($) {
    //Call this method on the wrapper of a $firstDateTextbox and a $lastDateTextbox 
    $.fn.initPeriodPicker = function (yearRange) {
        return this.each(function () {
            var $this = $(this);
            var minDateVar = new Date(yearRange[0], 0, 1);
            var maxDateVar = new Date(yearRange[1], 11,1);
            //var $firstDateTextbox = $('#' + $this.attr('id') + ' .$firstDateTextbox');
            var $firstDateTextbox = $this.find("input:first-of-type");
            var $lastDateTextbox = $this.find("input:last-of-type");
            var firstDateTextboxId = $firstDateTextbox.attr('id');
            var lastDateTextboxId = $firstDateTextbox.attr('id');
            var randomNum = Math.random();
            if(!firstDateTextboxId){
                firstDateTextboxId='firstDateTextbox' + randomNum;
                $firstDateTextbox.attr('id', firstDateTextboxId);
            }
            if(!lastDateTextboxId){
                lastDateTextboxId='lastDateTextbox' + randomNum;
                $lastDateTextbox.attr('id', lastDateTextboxId);
            }
            $firstDateTextbox.removeClass('hasDatepicker');
            $lastDateTextbox.removeClass('hasDatepicker');

            var options = {
                dateFormat: 'dd/mm/yy', showButtonPanel: true, changeMonth: true, changeYear: true, minDate: minDateVar, maxDate: maxDateVar,yearRange:yearRange[0]+":"+yearRange[1]
            };
            $firstDateTextbox.datepicker(options);
            $lastDateTextbox.datepicker(options);


            /*$firstDateTextbox.change(function () {
                var ds = Date.parseExact($(this).val(), ["dd/MM/yyyy"]);
                var de = Date.parseExact($(this).siblings('#'+lastDateTextboxId).val(), ["dd/MM/yyyy"]);
                if (ds != null) {
                    $(this).val(ds.toString("dd/MM/yyyy"))
                }
                if (ds == null) {
                    $(this).val("");
                    $(this).siblings('.startDagErrorMessage').text('Dit is geen datum');
                    $(this).siblings('.startDagErrorMessage').show();
                    setTimeout(function () {
                        $('.startDagErrorMessage').fadeOut();
                    }, 2500);
                }
                if (ds != null) {
                    if (ds.isBefore(minDateVar)) {
                        $(this).val("");
                        $(this).siblings('.startDagErrorMessage').text('Startdatum moet in of na ' + minYear + ' zijn!');
                        $(this).siblings('.startDagErrorMessage').show();
                        setTimeout(function () {
                            $('.startDagErrorMessage').fadeOut();
                        }, 2500);
                    }
                }

                if (ds != null && de != null) {
                    if (ds.isAfter(de)) {
                        $(this).val("");
                        $(this).siblings('.startDagErrorMessage').text('Startdatum moet voor einddatum zijn!');
                        $(this).siblings('.startDagErrorMessage').show();
                        setTimeout(function () {
                            $('.startDagErrorMessage').fadeOut();
                        }, 2500);
                    }
                }
            });
            $lastDateTextbox.change(function () {
                var ds = Date.parseExact($(this).siblings('#'+firstDateTextboxId).val(), ["dd/MM/yyyy"]);
                var de = Date.parseExact($(this).val(), ["dd/MM/yyyy"]);
                if (de != null) {
                    $(this).val(de.toString("dd/MM/yyyy"))
                }
                if (de == null) {
                    $(this).val("");
                    $(this).siblings('.eindDagErrorMessage').text('Dit is geen datum!');
                    $(this).siblings('.eindDagErrorMessage').show();
                    setTimeout(function () {
                        $('.eindDagErrorMessage').fadeOut();
                    }, 2500);
                }

                if (ds != null && de != null) {
                    if (de.isBefore(ds)) {
                        $(this).val("");
                        $(this).siblings('.eindDagErrorMessage').text('Einddatum moet na startdatum zijn!');
                        $(this).siblings('.eindDagErrorMessage').show();
                        setTimeout(function () {
                            $('.eindDagErrorMessage').fadeOut();
                        }, 2500);
                    }
                }
                if (de != null) {
                    if (de.isBefore(minDateVar)) {
                        $(this).val("");
                        $(this).siblings('.eindDagErrorMessage').text('Einddatum moet in of na ' + minYear + ' zijn!');
                        $(this).siblings('.eindDagErrorMessage').show();
                        setTimeout(function () {
                            $('.eindDagErrorMessage').fadeOut();
                        }, 2500);
                    }
                }
            });*/
        });
    };
})(jQuery);

(function ($) {
    //Call this method on the wrapper of a $firstDateTextbox and a $lastDateTextbox 
    $.fn.initDatePicker = function (minYear) {
        return this.each(function () {
            var $this = $(this);
            var minDateVar = new Date(minYear, 1 - 1, 1);
            var dagTxtBox = $('#' + $this.attr('id') + ' .dagTxtBox');
            //$('#' + $this.attr('id') + ' .$firstDateTextbox').datepicker({ dateFormat: 'dd/mm/yy', showButtonPanel: true, changeMonth: true, changeYear: true, minDate: minDateVar
            //});
            //$('#' + $this.attr('id') + ' .$lastDateTextbox').datepicker({ dateFormat: 'dd/mm/yy', showButtonPanel: true, changeMonth: true, changeYear: true, minDate: minDateVar
            //});
            //var randomNum = Math.random()
            //$firstDateTextbox.attr('id', '$firstDateTextbox' + randomNum);
            //$lastDateTextbox.attr('id', '$lastDateTextbox' + randomNum);
            //$firstDateTextbox.removeClass('hasDatepicker');
            //$lastDateTextbox.removeClass('hasDatepicker');

            //$this.find('.$firstDateTextbox,.$lastDateTextbox').datepicker({ dateFormat: 'dd/mm/yy', showButtonPanel: true, changeMonth: true, changeYear: true, minDate: minDateVar
            //});
            var commonVars = {
                dateFormat: 'dd/mm/yy', showButtonPanel: true, changeMonth: true, changeYear: true, minDate: minDateVar
            };

            dagTxtBox.datepicker(commonVars);

            dagTxtBox.change(function () {
                //$this.find('.$firstDateTextbox').change(function () {
                var ds = Date.parseExact($(this).val(), ["dd/MM/yyyy"]);
                //var de = Date.parseExact($(this).siblings('.$lastDateTextbox').val(), ["dd/MM/yyyy"]);
                if (ds != null) {
                    $(this).val(ds.toString("dd/MM/yyyy"))
                }
                if (ds == null) {
                    $(this).val("");
                    $(this).siblings('#dagErrorMessage').text('Dit is geen datum');
                    $(this).siblings('#dagErrorMessage').show();
                    setTimeout(function () {
                        $('#dagErrorMessage').fadeOut();
                    }, 2500);
                }
                if (ds != null) {
                    if (ds.isBefore(minDateVar)) {
                        $(this).val("");
                        $(this).siblings('#dagErrorMessage').text('Startdatum moet in of na ' + minYear + ' zijn!');
                        $(this).siblings('#dagErrorMessage').show();
                        setTimeout(function () {
                            $('#dagErrorMessage').fadeOut();
                        }, 2500);
                    }
                }
            });
        });
    };
})(jQuery);