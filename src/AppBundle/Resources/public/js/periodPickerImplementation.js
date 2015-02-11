
(function ($) {
    //Call this method on the wrapper of a startDagTxtBox and a eindDagTxtBox 
    $.fn.initPeriodPicker = function (minYear) {
        return this.each(function () {
            var $this = $(this);
            var minDateVar = new Date(minYear, 1 - 1, 1);
            var startDagTxtBox = $('#' + $this.attr('id') + ' .startDagTxtBox');
            var eindDagTxtBox = $('#' + $this.attr('id') + ' .eindDagTxtBox');
            //$('#' + $this.attr('id') + ' .startDagTxtBox').datepicker({ dateFormat: 'dd/mm/yy', showButtonPanel: true, changeMonth: true, changeYear: true, minDate: minDateVar
            //});
            //$('#' + $this.attr('id') + ' .eindDagTxtBox').datepicker({ dateFormat: 'dd/mm/yy', showButtonPanel: true, changeMonth: true, changeYear: true, minDate: minDateVar
            //});
            var randomNum = Math.random()
            startDagTxtBox.attr('id', 'startDagTxtBox' + randomNum);
            eindDagTxtBox.attr('id', 'eindDagTxtBox' + randomNum);
            startDagTxtBox.removeClass('hasDatepicker');
            eindDagTxtBox.removeClass('hasDatepicker');

            //$this.find('.startDagTxtBox,.eindDagTxtBox').datepicker({ dateFormat: 'dd/mm/yy', showButtonPanel: true, changeMonth: true, changeYear: true, minDate: minDateVar
            //});
            var commonVars = {
                dateFormat: 'dd/mm/yy', showButtonPanel: true, changeMonth: true, changeYear: true, minDate: minDateVar
            };

            startDagTxtBox.datepicker(commonVars);
            eindDagTxtBox.datepicker(commonVars);

            startDagTxtBox.change(function () {
                //$this.find('.startDagTxtBox').change(function () {
                var ds = Date.parseExact($(this).val(), ["dd/MM/yyyy"]);
                var de = Date.parseExact($(this).siblings('.eindDagTxtBox').val(), ["dd/MM/yyyy"]);
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
            //$this.find('.eindDagTxtBox').change(function () {
            eindDagTxtBox.change(function () {
                var ds = Date.parseExact($(this).siblings('.startDagTxtBox').val(), ["dd/MM/yyyy"]);
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
            });
        });
    };
})(jQuery);

(function ($) {
    //Call this method on the wrapper of a startDagTxtBox and a eindDagTxtBox 
    $.fn.initDatePicker = function (minYear) {
        return this.each(function () {
            var $this = $(this);
            var minDateVar = new Date(minYear, 1 - 1, 1);
            var dagTxtBox = $('#' + $this.attr('id') + ' .dagTxtBox');
            //$('#' + $this.attr('id') + ' .startDagTxtBox').datepicker({ dateFormat: 'dd/mm/yy', showButtonPanel: true, changeMonth: true, changeYear: true, minDate: minDateVar
            //});
            //$('#' + $this.attr('id') + ' .eindDagTxtBox').datepicker({ dateFormat: 'dd/mm/yy', showButtonPanel: true, changeMonth: true, changeYear: true, minDate: minDateVar
            //});
            //var randomNum = Math.random()
            //startDagTxtBox.attr('id', 'startDagTxtBox' + randomNum);
            //eindDagTxtBox.attr('id', 'eindDagTxtBox' + randomNum);
            //startDagTxtBox.removeClass('hasDatepicker');
            //eindDagTxtBox.removeClass('hasDatepicker');

            //$this.find('.startDagTxtBox,.eindDagTxtBox').datepicker({ dateFormat: 'dd/mm/yy', showButtonPanel: true, changeMonth: true, changeYear: true, minDate: minDateVar
            //});
            var commonVars = {
                dateFormat: 'dd/mm/yy', showButtonPanel: true, changeMonth: true, changeYear: true, minDate: minDateVar
            };

            dagTxtBox.datepicker(commonVars);

            dagTxtBox.change(function () {
                //$this.find('.startDagTxtBox').change(function () {
                var ds = Date.parseExact($(this).val(), ["dd/MM/yyyy"]);
                //var de = Date.parseExact($(this).siblings('.eindDagTxtBox').val(), ["dd/MM/yyyy"]);
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