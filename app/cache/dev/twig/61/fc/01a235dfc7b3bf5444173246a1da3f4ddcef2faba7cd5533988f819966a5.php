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
        // line 12
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "latDec", array()), 'row', array("label" => "Decimal latitude", "attr" => array("placeholder" => "eg. 51.224723")));
        echo "
    ";
        // line 13
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "lonDec", array()), 'row', array("label" => "Decimal longitude", "attr" => array("placeholder" => "eg. 2.9254719")));
        echo "
    ";
        // line 14
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "precisionFlag", array()), 'row', array("label" => "Location precision"));
        echo "</div>
<h4>Station</h4>

<div class=\"form-inline\">";
        // line 17
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "stnSeqno", array()), 'row', array("label" => "Station"));
        echo "</div>
<div class=\"form-inline\">";
        // line 18
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "cpnCode", array()), 'row', array("label" => "Campaign"));
        echo "</div>
<h3>Observation type</h3>

<div class=\"form-inline\">";
        // line 21
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "isconfidential", array()), 'row', array("label" => "Confidential observation?"));
        echo "</div>
<div class=\"form-inline\">";
        // line 22
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "osnType", array()), 'row', array("label" => "Observation type"));
        echo "</div>
<div class=\"form-inline\">";
        // line 23
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "samplingeffort", array()), 'row', array("label" => "Effort Related Survey?"));
        echo "</div>
<h3>Observation conditions</h3>
";
        // line 25
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "values", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["ov"]) {
            // line 26
            echo "    <h4>";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["ov"], "vars", array()), "value", array()), "pmdName", array()), "html", null, true);
            echo "</h4>
    <div class=\"form-inline\">";
            // line 27
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($context["ov"], "value", array()), 'row', array("label" => "Value"));
            echo "
        ";
            // line 28
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($context["ov"], "valueFlag", array()), 'row', array("label" => "Value flag"));
            echo "</div>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['ov'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 30
        echo "<h3>Observation comments</h3>
";
        // line 31
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "description", array()), 'row', array("label" => "Observation description"));
        echo "
    ";
        // line 32
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "webcommentsEn", array()), 'row', array("label" => "Event web comments: English"));
        echo "
    ";
        // line 33
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "webcommentsNl", array()), 'row', array("label" => "Event web comments: Dutch"));
        echo "
    ";
        // line 34
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
        return array (  114 => 34,  110 => 33,  106 => 32,  102 => 31,  99 => 30,  91 => 28,  87 => 27,  82 => 26,  78 => 25,  73 => 23,  69 => 22,  65 => 21,  59 => 18,  55 => 17,  49 => 14,  45 => 13,  41 => 12,  34 => 8,  30 => 7,  26 => 6,  19 => 1,);
    }
}
