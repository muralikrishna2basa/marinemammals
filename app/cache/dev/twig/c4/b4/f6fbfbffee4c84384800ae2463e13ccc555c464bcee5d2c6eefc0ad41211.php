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
        echo "<legend>Specimen</legend>
<h3>Enter existing specimen</h3>
<div class=\"form-inline\" id=\"existing-specimen\">
    ";
        // line 4
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "spec2event", array()), "scnSeqnoExisting", array()), 'row', array("label" => "Specimen id", "attr" => array("placeholder" => "A valid specimen seqno")));
        echo "
    <button id=\"b_search_scn\">Search for existing specimen in list</button>
</div>
<div id=\"new-specimen\">
    <h3>Add new specimen</h3>

    <div class=\"form-inline\">
        ";
        // line 11
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "spec2event", array()), "scnSeqnoNew", array()), "txnSeqno", array()), 'row', array("label" => "Species"));
        echo "
    </div>
    <div class=\"form-inline\">
        ";
        // line 14
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "spec2event", array()), "scnSeqnoNew", array()), "specieFlag", array()), 'row', array("label" => "Identification is certain?"));
        echo "
    </div>
    <div class=\"form-inline\">
        ";
        // line 17
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "spec2event", array()), "scnSeqnoNew", array()), "scnNumber", array()), 'row', array("label" => "Number"));
        echo "
    </div>
    <div class=\"form-inline no-multi\">
        ";
        // line 20
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "spec2event", array()), "scnSeqnoNew", array()), "sex", array()), 'row', array("label" => "Sex"));
        echo "
    </div>
    <div class=\"form-inline no-multi\">
        ";
        // line 23
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "spec2event", array()), "scnSeqnoNew", array()), "rbinsTag", array()), 'row', array("label" => "RBINS tag"));
        echo "
    </div>
    <div class=\"form-inline no-multi\">
        ";
        // line 26
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "spec2event", array()), "scnSeqnoNew", array()), "necropsyTag", array()), 'row', array("label" => "Necropsy tag"));
        echo "
    </div>
    <fieldset id=\"parameters\" class=\"no-multi\">
        <legend>Circumstantial parameters</legend>
        ";
        // line 30
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable(twig_slice($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "spec2event", array()), "values", array()), 0, 4));
        foreach ($context['_seq'] as $context["_key"] => $context["sv"]) {
            // line 31
            echo "            <h4>";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["sv"], "vars", array()), "value", array()), "pmdName", array()), "html", null, true);
            echo "</h4>
            <div class=\"form-inline\">";
            // line 32
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($context["sv"], "value", array()), 'row', array("label" => "Value"));
            echo "
                ";
            // line 33
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($context["sv"], "valueFlag", array()), 'row', array("label" => "Value flag"));
            echo "</div>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['sv'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 35
        echo "        <h3>Measurements</h3>
        ";
        // line 36
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable(twig_slice($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "spec2event", array()), "values", array()), 4, 8));
        foreach ($context['_seq'] as $context["_key"] => $context["sv"]) {
            // line 37
            echo "            <h4>";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["sv"], "vars", array()), "value", array()), "pmdName", array()), "html", null, true);
            echo "</h4>

            <div class=\"form-inline\">";
            // line 39
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($context["sv"], "value", array()), 'row', array("label" => "Value"));
            echo "
                ";
            // line 40
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($context["sv"], "valueFlag", array()), 'row', array("label" => "Value flag"));
            echo "</div>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['sv'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 42
        echo "    </fieldset>
</div>";
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
        return array (  117 => 42,  109 => 40,  105 => 39,  99 => 37,  95 => 36,  92 => 35,  84 => 33,  80 => 32,  75 => 31,  71 => 30,  64 => 26,  58 => 23,  52 => 20,  46 => 17,  40 => 14,  34 => 11,  24 => 4,  19 => 1,);
    }
}
