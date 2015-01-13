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
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'form_start', array("method" => "POST", "action" => $this->env->getExtension('routing')->getPath("mm_observations_add_create")));
        echo "
<div class=\"subform\">
    <h2>Observation</h2>
    <ul class=\"formelements\" id=\"observation_elements\">
        <li>
            <h3>Date and time</h3>
            <ul>
                <li>
                    ";
        // line 9
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "eventDatetime", array()), 'row', array("label" => "Date", "attr" => array("placeholder" => "dd/mm/yyyy")));
        echo "
                    ";
        // line 10
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "eventDatetimeFlag", array()), 'row', array("label" => "Date flag"));
        echo "</li>
            </ul>
        </li>
        <li>
            <h3>Location</h3>
            <ul>
                <li><h4>Exact Coordinates</h4>
                <ul><li>";
        // line 17
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "latDeg", array()), 'row', array("label" => "Decimal latitude", "attr" => array("placeholder" => "eg. 51.224723")));
        echo "
                    ";
        // line 18
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "lonDeg", array()), 'row', array("label" => "Decimal longitude", "attr" => array("placeholder" => "eg. 2.9254719")));
        echo "
                    ";
        // line 19
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "precisionFlag", array()), 'row', array("label" => "Location precision"));
        echo "</li></ul>
                <li>
                    <h4>Station</h4>
                    <ul>
                        <li>";
        // line 23
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "stnSeqno", array()), 'row', array("label" => "Station"));
        echo "</li>
                    </ul>
                </li>
            </ul>
        </li>
        <li>
            <h3>Observation type</h3>
            <ul>
                <li>";
        // line 31
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "isconfidential", array()), 'row', array("label" => "Confidential observation?"));
        echo "</li>
                <li>";
        // line 32
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "osnType", array()), 'row', array("label" => "Observation type"));
        echo "
                    ";
        // line 33
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "samplingeffort", array()), 'row', array("label" => "Effort Related Survey?"));
        echo "
                </li>
            </ul>
        </li>
        <li>
            <h3>Observation conditions</h3>
            ";
        // line 39
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "observationValues", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["ov"]) {
            // line 40
            echo "                <h4>";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["ov"], "vars", array()), "value", array()), "pmdName", array()), "html", null, true);
            echo "</h4>
                ";
            // line 41
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($context["ov"], "value", array()), 'row', array("label" => "Value"));
            echo "
                ";
            // line 42
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($context["ov"], "valueFlag", array()), 'row', array("label" => "Value flag"));
            echo "
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['ov'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 44
        echo "        </li>
        <li>
            <h3>Observation comments</h3>
            <ul>
                <li>
                    ";
        // line 49
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "description", array()), 'row', array("label" => "Observation description"));
        echo "</li>

                <li>
                    ";
        // line 52
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "webcommentsEn", array()), 'row', array("label" => "Event web comments: English"));
        echo "
                    ";
        // line 53
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "webcommentsNl", array()), 'row', array("label" => "Event web comments: Dutch"));
        echo "
                    ";
        // line 54
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "webcommentsFr", array()), 'row', array("label" => "Event web comments: French"));
        echo "
                </li>
            </ul>
        </li>
    </ul>
    <p>
        <input type=\"submit\" value=\"Submit\">
    </p>
</div>

";
        // line 64
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'form_end');
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
        return array (  142 => 64,  129 => 54,  125 => 53,  121 => 52,  115 => 49,  108 => 44,  100 => 42,  96 => 41,  91 => 40,  87 => 39,  78 => 33,  74 => 32,  70 => 31,  59 => 23,  52 => 19,  48 => 18,  44 => 17,  34 => 10,  30 => 9,  19 => 1,);
    }
}
