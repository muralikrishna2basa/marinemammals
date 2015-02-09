<?php

/* AppBundle:Bare:add-specimens.html.twig */
class __TwigTemplate_c4b4f6fbfbffee4c84384800ae2463e13ccc555c464bcee5d2c6eefc0ad41211 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<legend><h2>Specimen</h2></legend>
<fieldset id=\"existing-specimen\">
    <legend><h3>Enter existing specimen</h3></legend>
    <div class=\"form-inline\">
        ";
        // line 5
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "spec2events", array()), "scnSeqnoExisting", array()), 'row', array("label" => "Specimen id", "attr" => array("placeholder" => "A valid specimen seqno")));
        echo "
        <button id=\"b_search_scn\">Search for existing specimen in list</button>
    </div>
</fieldset>
<fieldset id=\"new-specimen\">
    <legend><h3>New specimen</h3></legend>

    <div class=\"form-inline\">
        ";
        // line 13
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "spec2events", array()), "scnSeqnoNew", array()), "txnSeqno", array()), 'row', array("label" => "Species"));
        echo "
    </div>
    <div class=\"form-inline\">
        ";
        // line 16
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "spec2events", array()), "scnSeqnoNew", array()), "identificationCertainty", array()), 'row', array("label" => "Identification is certain?"));
        echo "
    </div>
    <div class=\"form-inline\">
        ";
        // line 19
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "spec2events", array()), "scnSeqnoNew", array()), "scnNumber", array()), 'row', array("label" => "Number"));
        echo "
    </div>
    <div class=\"form-inline no-multi\">
        ";
        // line 22
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "spec2events", array()), "scnSeqnoNew", array()), "sex", array()), 'row', array("label" => "Sex"));
        echo "
    </div>
    <div class=\"form-inline no-multi\">
        ";
        // line 25
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "spec2events", array()), "scnSeqnoNew", array()), "rbinsTag", array()), 'row', array("label" => "RBINS tag"));
        echo "
    </div>
    <div class=\"form-inline no-multi\">
        ";
        // line 28
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "spec2events", array()), "scnSeqnoNew", array()), "necropsyTag", array()), 'row', array("label" => "Necropsy tag"));
        echo "
    </div>
</fieldset>
    <fieldset id=\"circumstantial_values\" class=\"no-multi\">
        <legend><h4>Circumstantial parameters</h4></legend>
        ";
        // line 33
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "spec2events", array()), "circumstantialValues", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["sv"]) {
            // line 34
            echo "            <h5>";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["sv"], "vars", array()), "value", array()), "pmdName", array()), "html", null, true);
            echo "</h5>
            <div class=\"form-inline\">";
            // line 35
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($context["sv"], "value", array()), 'row', array("label" => "Value"));
            echo "
                ";
            // line 36
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($context["sv"], "valueFlag", array()), 'row', array("label" => "Value flag"));
            echo "</div>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['sv'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 38
        echo "    </fieldset>
   <fieldset id=\"measurement_values\" class=\"no-multi\">
        <legend><h4>Measurements</h4></legend>
        ";
        // line 41
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "spec2events", array()), "measurementValues", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["sv"]) {
            // line 42
            echo "            <h5>";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["sv"], "vars", array()), "value", array()), "pmdName", array()), "html", null, true);
            echo "</h5>
            <div class=\"form-inline\">";
            // line 43
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($context["sv"], "value", array()), 'row', array("label" => "Value"));
            echo "
                ";
            // line 44
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($context["sv"], "valueFlag", array()), 'row', array("label" => "Value flag"));
            echo "</div>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['sv'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 46
        echo "    </fieldset>
<fieldset id=\"values\" class=\"no-multi\">
    <legend><h4>All specimen values</h4></legend>
    ";
        // line 49
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "spec2events", array()), "values", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["sv"]) {
            // line 50
            echo "        <h5>";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["sv"], "vars", array()), "value", array()), "pmdName", array()), "html", null, true);
            echo "</h5>
        <div class=\"form-inline\">";
            // line 51
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($context["sv"], "value", array()), 'row', array("label" => "Value"));
            echo "
        </div>

    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['sv'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 55
        echo "</fieldset>";
    }

    public function getTemplateName()
    {
        return "AppBundle:Bare:add-specimens.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  145 => 55,  135 => 51,  130 => 50,  126 => 49,  121 => 46,  113 => 44,  109 => 43,  104 => 42,  100 => 41,  95 => 38,  87 => 36,  83 => 35,  78 => 34,  74 => 33,  66 => 28,  60 => 25,  54 => 22,  48 => 19,  42 => 16,  36 => 13,  25 => 5,  19 => 1,);
    }
}
