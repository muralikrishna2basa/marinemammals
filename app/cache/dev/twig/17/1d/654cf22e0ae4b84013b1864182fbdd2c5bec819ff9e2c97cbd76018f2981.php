<?php

/* AppBundle:Page:add-observations-specimens.html.twig */
class __TwigTemplate_171d654cf22e0ae4b84013b1864182fbdd2c5bec819ff9e2c97cbd76018f2981 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("AppBundle::nocol-layout.html.twig");

        $this->blocks = array(
            'javascripts' => array($this, 'block_javascripts'),
            'main_content' => array($this, 'block_main_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "AppBundle::nocol-layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_javascripts($context, array $blocks = array())
    {
        // line 3
        echo "    ";
        $this->displayParentBlock("javascripts", $context, $blocks);
        echo "
    <script type=\"application/javascript\" src=\"/js/jquery.easytabs.min.js\"></script>
    <script type=\"application/javascript\" src=\"/js/addsymfonyprototype.js\"></script>
    <script type=\"application/javascript\" src=\"/js/date.js\"></script>
    <script type=\"application/javascript\"
            src=\"http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js\"></script>
    <script type=\"application/javascript\"
            src=\"http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/additional-methods.min.js\"></script>
    ";
        // line 17
        echo "    <script type=\"application/javascript\">
        var \$tabs = \$('.tab');
        var wholeForm = \$('#observationform');
        var \$wholeFormErrors = \$('#formerror');
        var \$currentTab = \$(\"a[href='tabs-1']\").parent();
        var \$currentPanel = \$('#tabs-1');
        var \$previousTab;
        var \$previousPanel;
        \$(document).ready(function () {
            //TODO: chosen persons can't be the same for gathering and observing

            \$tabs.not(\$currentTab).not(\$previousTab).addClass('disabled');
            \$(\"#observationform\").easytabs({
                tabs: \".nav-tabs li\",
                animate: false,
                tabActiveClass: \"active\"
            }).bind('easytabs:before', function (evt, destTab, destPanel, data) {
                var \$currentTab = \$(this).find('li.active');
                var \$currentPanel = \$(this).find('fieldset.active');
                var goBack = destTab.parent().isBefore(\$currentTab); //destTab is actually the anchor
                var valid = validateContainer(\$currentPanel, validator);

                if (valid) {
                    \$wholeFormErrors.html = '';
                    \$previousTab = \$currentTab;
                    \$previousPanel = \$currentPanel;
                    \$currentTab = destTab;
                    \$currentPanel = destPanel;
                }
                else{
                    \$tabs.not(\$currentTab).not(\$previousTab).addClass('disabled');
                }
                return valid || goBack;
            });

            \$('.prev-tab').click(function () {
                var currTab;
                currTab = \$('a.active').attr('href');
                var i = ( parseInt(currTab.match(/\\d+/)) - 2 );
                \$tabs.children('a:eq(' + i + ')').click();
            });

            \$('.next-tab').click(function () {
                var currTab;
                currTab = \$('a.active').attr('href');
                var i = ( parseInt(currTab.match(/\\d+/)) );
                \$tabs.children('a:eq(' + i + ')').click();
            });


            //  if (\$('.radio label')[0].childNodes[0].nodeValue = 'unknown') {
            //      \$(this).find('input[checked]').attr('checked', 'checked');
            //  }
            //  \$('.no-multi').find('input[checked]').removeAttr('checked');
            var existingSpecimenChoiceField = \$('#observationstype_eseSeqno_spec2events_scnSeqnoExisting');
            var newSpecimenChoiceField = \$('#observationstype_eseSeqno_spec2events_scnSeqnoNew_txnSeqno');
            var newSpecimenNumberField = \$('#observationstype_eseSeqno_spec2events_scnSeqnoNew_scnNumber');
            var newSpecimenBox = \$('#new-specimen');
            var newSpecimenBox_requiredInputSelect = newSpecimenBox.find('[required=\"required\"]');
            var fieldsAndBoxesThatAreIllegalOnMultipleSpecimens = \$('.no-multi');
            var fieldsAndBoxesThatAreIllegalOnMultipleSpecimens_requiredInputSelect = fieldsAndBoxesThatAreIllegalOnMultipleSpecimens.find('[required=\"required\"]');
            var latDecField = \$('#observationstype_latDec');
            var lonDecField = \$('#observationstype_lonDec');
            var allNonRequiredInputSelectValues = \$(\"select[id\$='value'],input[id\$='value']\").not(\"[required='required']\");
            existingSpecimenChoiceField.change(function () {
                var value = \$(this).val();
                var newSpecimenBox_allInput = newSpecimenBox.find('input');
                var newSpecimenBox_allSelect = newSpecimenBox.find('select');
                if (/^[0-9]+\$/.test(value)) {
                    \$(this).attr('required', 'required');
                    newSpecimenBox_requiredInputSelect.removeAttr('required');
                    newSpecimenBox_allInput.val('');
                    newSpecimenBox_allSelect.prop('selectedIndex', 0);
                    newSpecimenBox.hide();
                    return false;
                }
                if (value === '') {
                    newSpecimenBox_requiredInputSelect.attr('required', 'required');
                    newSpecimenBox.show();
                    return false;
                }
            });
            newSpecimenChoiceField.change(function () {
                var value = \$(this).val();
                if (value != '') {
                    existingSpecimenChoiceField.removeAttr('required').val('');
                }
                else {
                    existingSpecimenChoiceField.attr('required', 'required');
                }
                return false;
            });
            newSpecimenNumberField.change(function () {
                if (\$(this).val() > 1) {
                    fieldsAndBoxesThatAreIllegalOnMultipleSpecimens.find('input').val('');
                    fieldsAndBoxesThatAreIllegalOnMultipleSpecimens.find('select').prop('selectedIndex', 0);
                    fieldsAndBoxesThatAreIllegalOnMultipleSpecimens.find('input[checked]').removeAttr('checked');
                    fieldsAndBoxesThatAreIllegalOnMultipleSpecimens_requiredInputSelect.removeAttr('required');
                    fieldsAndBoxesThatAreIllegalOnMultipleSpecimens.hide();
                    return false;
                }
                if (\$(this).val() < 2) {
                    fieldsAndBoxesThatAreIllegalOnMultipleSpecimens_requiredInputSelect.attr('required', 'required');
                    fieldsAndBoxesThatAreIllegalOnMultipleSpecimens.show();
                    return false;
                }
            });

            latDecField.change(function () {
                        makeAssociatedFlagRequired(\$(this))
                    }
            );

            allNonRequiredInputSelectValues.change(function () {
                        makeAssociatedFlagRequired(\$(this))
                    }
            );

            var sfp1 = new SymfonyPrototype(\$('ul.e2p_observer'), \$('<a href=\"#\" id=\"add_observer\">Add a person</a>'), '__observers_name__');
            sfp1.addAddLink();
            var sfp2 = new SymfonyPrototype(\$('ul.e2p_gatherer'), \$('<a href=\"#\" id=\"add_gatherer\">Add a person</a>'), '__gatherers_name__');
            sfp2.addAddLink();

            \$.validator.addMethod(\"dateBE\", function (value) {
                var dt = Date.parseExact(value, [\"dd/MM/yyyy\"]);
                return dt != null;
            }, 'Not a valid date. The correct date format is dd/mm/yyyy');

            \$.validator.addMethod(\"validNecropsyTag\", function (value) {
                return /^\$|^[a-zA-Z]{2}[_]{1}[0-9]{4}[_]{1}[0-9]{1,6}\$/.test(value);
            }, 'Not a necropsy tag. The correct format is BE/FR_yyyy_integer, eg. BE_1996_15');

            \$.validator.addMethod(\"validLatDec\", function (value) {
                return validCoord(value, lonDecField.val()) && validLatDec(value);
            }, '2 problems: either complete longitude or this value is not a decimal latitude (-90.0 <= x <= 90.0)');

            \$.validator.addMethod(\"validLonDec\", function (value) {
                return validCoord(latDecField.val(), value) && validLonDec(value);
            }, '2 problems: either complete latitude or this value is not a decimal longitude (-180.0 <= x <= 180.0)');

            \$.validator.addMethod(\"validStation\", function (value) {
                return stationOrCoord(value, latDecField.val(), lonDecField.val());
            }, 'Please provide either a valid coordinate or a station, or both');

            var validator = wholeForm.validate({
                ignore: \"\",
                rules: {
                    \"observationstype[eseSeqno][eventDatetime][date]\": 'dateBE',
                    \"observationstype[latDec]\": 'validLatDec',
                    \"observationstype[lonDec]\": 'validLonDec',
                    \"observationstype[eseSeqno][spec2events][scnSeqnoExisting]\": {
                        digits: true
                    },
                    \"observationstype[eseSeqno][spec2events][scnSeqnoNew][scnNumber]\": {
                        digits: true
                    },
                    \"observationstype[eseSeqno][spec2events][scnSeqnoNew][necropsyTag]\": 'validNecropsyTag'
                },
                showErrors: function (errorMap, errorList) {
                    \$.each(this.validElements(), cleanError);
                    \$.each(errorList, createError);
                }
            });
        });

        (function (\$) {
            \$.fn.isAfter = function (sel) {
                return this.prevAll().filter(sel).length !== 0;
            };

            \$.fn.isBefore = function (sel) {
                return this.nextAll().filter(sel).length !== 0;
            };
        })(jQuery);

        function makeAssociatedFlagRequired(\$element) {
            var id = \$element.attr('id');
            var \$associatedFlag = \$(\".\" + id + \"Flag\");//in some cases class is used; reason see add-observations.html.twig; precisionFlag is the actual id instead of lonDecFlag.

            if (!\$associatedFlag.length) {
                \$associatedFlag = \$(\"#\" + id + \"Flag\");
            }
            var value = \$element.val();
            if (value != '') {
                \$associatedFlag.attr('required', 'required');
                validator.element(\$associatedFlag);
            }
            else {
                \$associatedFlag.removeAttr('required');
                validator.element(\$associatedFlag);
            }
        }

        function validateContainer(\$container, validator) {
            var \$elements = \$('#' + \$container.attr('id') + ' :input');
            var valid = true;
            \$elements.each(function () {
                var id = \$(this).attr('id');
                if (!validator.element(\$('#' + id))) {
                    valid = false;
                }
            });
            return valid;
        }

        function createError(index, error) {
            var \$element = \$(error.element).closest(\"div\");
            var \$group = \$(error.element).closest(\".form-group\");
            \$('#formerror').html(\"There is a problem with your submission. Please see above for error icons.\");

            \$tabs.not(\$currentTab).not(\$previousTab).addClass('disabled');

            \$element.tooltip(\"destroy\")
                    .data(\"title\", error.message)
                    .tooltip();
            \$group.removeClass(\"has-success\").addClass(\"has-error has-feedback\");
            if (\$group.find(\"span.glyphicon\").length === 0) {
                \$group.append('<span class=\"glyphicon glyphicon-warning-sign form-control-feedback\"> </span>');
            } else {
                \$group.find(\"span.glyphicon\").removeClass(\"glyphicon-ok\").addClass(\"glyphicon-warning-sign\");
            }
        }

        function cleanError(index, element) {
            var \$element = \$(element).closest(\"div\");
            var \$group = \$(element).closest(\".form-group\");
            \$element.data(\"title\", \"\").tooltip(\"destroy\");

            \$tabs.not(\$currentTab).removeClass('disabled');

            \$group.removeClass(\"has-error\").addClass(\"has-success has-feedback\");
            if (\$group.find(\"span.glyphicon\").length === 0) {
                \$group.append('<span class=\"glyphicon glyphicon-ok form-control-feedback\"> </span>');
            } else {
                \$group.find(\"span.glyphicon\").removeClass(\"glyphicon-warning-sign\").addClass(\"glyphicon-ok\");
            }
        }

        function apply_tooltip_options(element, message) {
            var options = {
                /* Using Twitter Bootstrap Defaults if no settings are given */
                animation: \$(element).data('animation') || true,
                html: \$(element).data('html') || false,
                placement: \$(element).data('placement') || 'top',
                selector: \$(element).data('animation') || false,
                title: \$(element).attr('title') || message,
                trigger: \$.trim('manual ' + (\$(element).data('trigger') || '')),
                delay: \$(element).data('delay') || 0,
                container: \$(element).data('container') || false
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
            return /^\$|^(\\+|-)?(\\d\\.\\d{1,6}|[1-8]\\d\\.\\d{1,6}|90\\.0{1,6})\$/.test(latDec);
        }

        function validLonDec(lonDec) {
            return /^\$|^(\\+|-)?([0-9][0-9]?.\\d{1,6}|1[0-7][0-9].\\d{1,6}|180.\\d{1,6})\$/.test(lonDec);
        }

    </script>
";
    }

    // line 302
    public function block_main_content($context, array $blocks = array())
    {
        // line 303
        echo "    <div class=\"col-lg-12\">
        ";
        // line 304
        echo twig_include($this->env, $context, "AppBundle:Bare:add-observations-specimens.html.twig");
        echo "
    </div>
";
    }

    public function getTemplateName()
    {
        return "AppBundle:Page:add-observations-specimens.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  338 => 304,  335 => 303,  332 => 302,  44 => 17,  32 => 3,  29 => 2,);
    }
}
