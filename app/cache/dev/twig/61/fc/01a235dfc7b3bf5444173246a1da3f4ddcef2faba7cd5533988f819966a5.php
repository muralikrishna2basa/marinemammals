<?php

/* AppBundle:Bare:add-observations.html.twig */
class __TwigTemplate_61fc01a235dfc7b3bf5444173246a1da3f4ddcef2faba7cd5533988f819966a5 extends Twig_Template
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
        echo "<legend>Observation</legend>

<h3>Date and time</h3>

<div class=\"form-inline\">
    ";
        // line 6
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "eventDatetime", array()), "date", array()), 'row', array("label" => "Date", "attr" => array("placeholder" => "dd/mm/yyyy")));
        echo "
    ";
        // line 7
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "eventDatetime", array()), "time", array()), 'row', array("label" => "Time", "attr" => array("placeholder" => "hh:mm")));
        echo "
    ";
        // line 8
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "eventDatetimeFlag", array()), 'row', array("label" => "Date flag"));
        echo "</div>
<h3>Location</h3>
<h4>Exact Coordinates</h4>
<div class=\"form-inline\">";
        // line 11
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "latDec", array()), 'row', array("label" => "Decimal latitude", "attr" => array("placeholder" => "eg. 51.224723")));
        echo "
    ";
        // line 12
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "lonDec", array()), 'row', array("label" => "Decimal longitude", "attr" => array("placeholder" => "eg. 2.9254719")));
        echo "
    ";
        // line 13
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "precisionFlag", array()), 'row', array("label" => "Location precision", "attr" => array("class" => "observationstype_latDecFlag")));
        echo "</div>
<h4>Station</h4>

<div class=\"form-inline\">";
        // line 16
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "stnSeqno", array()), 'row', array("label" => "Station"));
        echo "</div>
<div class=\"form-inline\">";
        // line 17
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "cpnCode", array()), 'row', array("label" => "Campaign"));
        echo "</div>
<h3>Observation type</h3>

<div class=\"form-inline\">";
        // line 20
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "isconfidential", array()), 'row', array("label" => "Confidential observation?"));
        echo "</div>
<div class=\"form-inline\">";
        // line 21
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "osnType", array()), 'row', array("label" => "Observation type"));
        echo "</div>
<div class=\"form-inline\">";
        // line 22
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "samplingeffort", array()), 'row', array("label" => "Effort Related Survey?"));
        echo "</div>
<h3>Observation conditions</h3>
";
        // line 24
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "values", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["ov"]) {
            // line 25
            echo "    <h4>";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["ov"], "vars", array()), "value", array()), "pmdName", array()), "html", null, true);
            echo "</h4>
    <div class=\"form-inline\">";
            // line 26
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($context["ov"], "value", array()), 'row', array("label" => "Value"));
            echo "
        ";
            // line 27
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($context["ov"], "valueFlag", array()), 'row', array("label" => "Value flag"));
            echo "</div>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['ov'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 29
        echo "<h3>Observation comments</h3>
";
        // line 30
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "description", array()), 'row', array("label" => "Observation description"));
        echo "
    ";
        // line 31
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "webcommentsEn", array()), 'row', array("label" => "Event web comments: English"));
        echo "
    ";
        // line 32
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "webcommentsNl", array()), 'row', array("label" => "Event web comments: Dutch"));
        echo "
    ";
        // line 33
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "webcommentsFr", array()), 'row', array("label" => "Event web comments: French"));
        echo "
";
    }

    public function getTemplateName()
    {
        return "AppBundle:Bare:add-observations.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  113 => 33,  109 => 32,  105 => 31,  101 => 30,  98 => 29,  90 => 27,  86 => 26,  81 => 25,  77 => 24,  72 => 22,  68 => 21,  64 => 20,  58 => 17,  54 => 16,  48 => 13,  44 => 12,  40 => 11,  34 => 8,  30 => 7,  26 => 6,  19 => 1,);
    }
}
