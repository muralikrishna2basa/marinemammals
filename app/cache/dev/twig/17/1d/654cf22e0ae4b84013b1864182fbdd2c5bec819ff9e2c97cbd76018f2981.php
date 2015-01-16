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
    <script type=\"application/javascript\" src=\"/js/jquery.easytabs.js\"></script>
    <script type=\"application/javascript\">
        \$(function() {
            \$( \"#tabs\" ).easytabs({tabs: \".nav-tabs li\"});
        });
        \$( document ).ready(function() {
            \$('#observationstype_eseSeqno_spec2event_scnSeqnoExisting').change(function() {
                var val=\$(this).val();
                if(/^[0-9]+\$/.test(val)){
                    \$('#observationstype_eseSeqno_spec2event_scnSeqnoExisting').find('[mandatory=\"false\"]').attr('required','required');
                    \$('#new-specimen').find('[required=\"required\"]').attr('mandatory','false');
                    \$('#new-specimen').find('input[required=\"required\"]').val('');
                    \$('#new-specimen').find('select[required=\"required\"]').prop('selectedIndex',0);
                    \$('#new-specimen').find('[required=\"required\"]').removeAttr('required');
                    \$('#new-specimen').hide();
                    return false;
                }
                if(val===''){
                    \$('#new-specimen').find('[mandatory=\"false\"]').attr('required','required');
                    \$('#new-specimen').show();
                    return false;
                }
            });
            \$('#observationstype_eseSeqno_spec2event_scnSeqnoNew_txnSeqno').change(function() {
                \$('#observationstype_eseSeqno_spec2event_scnSeqnoExisting').attr('mandatory','false');
                \$('#observationstype_eseSeqno_spec2event_scnSeqnoExisting').removeAttr('required');
                \$('#observationstype_eseSeqno_spec2event_scnSeqnoExisting').val('');
                return false;
            });
            \$('#observationstype_eseSeqno_spec2event_scnSeqnoNew_scnNumber').change(function() {
                if(\$(this).val()>1){
                    \$('#parameters').find('input').val('');
                    \$('#parameters').find('select').prop('selectedIndex',0);
                    \$('.no-multi').find('input').val('');
                    \$('.no-multi').find('select').prop('selectedIndex',0);
                    \$('.no-multi').hide();
                    \$('#parameters').hide();
                    return false;
                }
                if(\$(this).val()<2){
                    \$('.no-multi').show();
                    \$('#parameters').show();
                    return false;
                }
            });
        });
    </script>
";
    }

    // line 52
    public function block_main_content($context, array $blocks = array())
    {
        // line 53
        echo "    <div class=\"col-lg-12\">
        ";
        // line 54
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
        return array (  92 => 54,  89 => 53,  86 => 52,  32 => 3,  29 => 2,);
    }
}
