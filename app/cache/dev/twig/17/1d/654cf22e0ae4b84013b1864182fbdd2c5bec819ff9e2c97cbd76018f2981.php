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
        \$(document).ready(function () {
            //TODO: chosen persons can't be the same for gathering and observing
            \$(\"#observationform\").easytabs({
                tabs: \".nav-tabs li\",
                animate: false,
                tabActiveClass: \"active\"
            });

            var \$tabs = \$('.tab');
            var \$tabContainer = \$('.subformcontainer');

            \$('.prev-tab').click(function () {
                var currTab, i;
                currTab = \$('a.active').attr('href');
                var i = ( parseInt(currTab.match(/\\d+/)) - 2 );
                \$tabs.children('a:eq(' + i + ')').click();
            });

            \$('.next-tab').click(function () {
                var currTab, i;
                currTab = \$('a.active').attr('href');
                var i = ( parseInt(currTab.match(/\\d+/)) );
                \$tabs.children('a:eq(' + i + ')').click();
            });


            //  if (\$('.radio label')[0].childNodes[0].nodeValue = 'unknown') {
            //      \$(this).find('input[checked]').attr('checked', 'checked');
            //  }
            //  \$('.no-multi').find('input[checked]').removeAttr('checked');
            var wholeForm=\$('#observationform');
            var existingSpecimenChoiceField = \$('#observationstype_eseSeqno_spec2event_scnSeqnoExisting');
            var newSpecimenChoiceField = \$('#observationstype_eseSeqno_spec2event_scnSeqnoNew_txnSeqno');
            var newSpecimenNumberField = \$('#observationstype_eseSeqno_spec2event_scnSeqnoNew_scnNumber');
            var newSpecimenBox = \$('#new-specimen');
            var newSpecimenBox_requiredInputSelect = newSpecimenBox.find('[required=\"required\"]');
            var fieldsAndBoxesThatAreIllegalOnMultipleSpecimens = \$('.no-multi');
            var fieldsAndBoxesThatAreIllegalOnMultipleSpecimens_requiredInputSelect = fieldsAndBoxesThatAreIllegalOnMultipleSpecimens.find('[required=\"required\"]');
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
            allNonRequiredInputSelectValues.change(function () {
                var id = \$(this).attr('id');
                var value = \$(this).val();
                if (value != '') {
                    \$(\"#\" + id + \"Flag\").attr('required', 'required');
                }
                else {
                    \$(\"#\" + id + \"Flag\").removeAttr('required');
                }
            });

            var sfp1 = new SymfonyPrototype(\$('ul.e2p_observer'), \$('<a href=\"#\" id=\"add_observer\">Add a person</a>'), '__observers_name__');
            sfp1.addAddLink();
            var sfp2 = new SymfonyPrototype(\$('ul.e2p_gatherer'), \$('<a href=\"#\" id=\"add_gatherer\">Add a person</a>'), '__gatherers_name__');
            sfp2.addAddLink();
            \$.validator.setDefaults({
                debug: true,
                success: 'valid'
            });
            \$.validator.addMethod(\"dateBE\", function(value) {
                var dt = Date.parseExact(value, [\"dd/MM/yyyy\"]);
                return dt != null;
            }, 'Not a valid date. The correct date format is dd/mm/yyyy');
            \$.validator.addMethod(\"necropsytag\", function(value) {
                return /^[a-zA-Z]{2}[_]{1}[0-9]{4}[_]{1}[0-9]+\$/.test(value);
            }, 'Not a necropsy tag. The correct format is BE/FR_yyyy_integer, eg. BE_1996_15');
            \$.validator.addMethod(\"latdec\", function(value) {
                return /^(\\+|-)?(\\d\\.\\d{1,6}|[1-8]\\d\\.\\d{1,6}|90\\.0{1,6})\$/.test(value);
            }, 'Not a decimal latitude: -90.0 <= x <= 90.0');
            \$.validator.addMethod(\"londec\", function(value) {
                return /^(\\+|-)?(\\d\\.\\d{1,6}|[1-8]\\d\\.\\d{1,6}|180\\.0{1,6})\$/.test(value);
            }, 'Not a decimal longitude: -180.0 <= x <= 180.0');

            wholeForm.validate({
                rules: {
                    \"observationstype[eseSeqno][eventDatetime][date]\": 'dateBE',
                    \"observationstype[latDec]\": 'latdec',
                    \"observationstype[lonDec]\": 'londec',
                    \"observationstype[eseSeqno][spec2event][scnSeqnoExisting]\": {
                        digits: true
                    },
                    \"observationstype[eseSeqno][spec2event][scnSeqnoNew][scnNumber]\": {
                        digits: true
                    },
                    \"observationstype[eseSeqno][spec2event][scnSeqnoNew][necropsyTag]\":'necropsytag'
                },

                messages:{
            'observationstype[eseSeqno][eventDatetime][date]': {
                        dateNL: 'The date format is dd/mm/yyyy'
                    }
                }
            });
            wholeForm.validate({lang: 'nl'});
        });
    </script>
";
    }

    // line 157
    public function block_main_content($context, array $blocks = array())
    {
        // line 158
        echo "    <div class=\"col-lg-12\">
        ";
        // line 159
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
        return array (  193 => 159,  190 => 158,  187 => 157,  44 => 17,  32 => 3,  29 => 2,);
    }
}
