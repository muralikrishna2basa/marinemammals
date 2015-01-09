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
        echo "<div class=\"subform\">
    <h2>Observation</h2>
";
        // line 3
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'form_start', array("method" => "POST", "action" => $this->env->getExtension('routing')->getPath("mm_observations_add_create")));
        echo "
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
            <h3>Observation comments</h3>
            <ul>
                <li>
                    ";
        // line 17
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "description", array()), 'row', array("label" => "Observation description"));
        echo "</li>

                <li>
                    ";
        // line 20
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "webcommentsEn", array()), 'row', array("label" => "Event web comments: English"));
        echo "
                    ";
        // line 21
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "webcommentsNl", array()), 'row', array("label" => "Event web comments: Dutch"));
        echo "
                    ";
        // line 22
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "webcommentsFr", array()), 'row', array("label" => "Event web comments: French"));
        echo "
                </li>
            </ul>
        </li>
        <li>
            <h3>Location</h3>
            <ul>
                <li><h4>Exact Coordinates</h4>
                <ul><li>";
        // line 30
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "latDeg", array()), 'row', array("label" => "Decimal latitude", "attr" => array("placeholder" => "eg. 51.224723")));
        echo "
                    ";
        // line 31
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "lonDeg", array()), 'row', array("label" => "Decimal longitude", "attr" => array("placeholder" => "eg. 2.9254719")));
        echo "
                    ";
        // line 32
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "precisionFlag", array()), 'row', array("label" => "Location precision"));
        echo "</li></ul>
                <li>
                    <h4>Station</h4>
                    <ul>
                        <li>";
        // line 36
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
        // line 44
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "confidentiality", array()), 'row', array("label" => "Confidential observation"));
        echo "</li>
                <li>";
        // line 45
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "osnType", array()), 'row', array("label" => "Observation type"));
        echo "
                    ";
        // line 46
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "samplingeffort", array()), 'row', array("label" => "Effort Related Survey?"));
        echo "
                </li>
            </ul>
        </li>
        <li>
            <h3>Observation conditions</h3>
            ";
        // line 52
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "observationValues", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["ov"]) {
            // line 53
            echo "                ";
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($context["ov"], "value", array()), 'row', array("label" => "Value"));
            echo "
                ";
            // line 54
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($context["ov"], "valueFlag", array()), 'row', array("label" => "Value flag"));
            echo "
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['ov'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 56
        echo "        </li>
    </ul>
    <p>
        <input type=\"submit\" value=\"Submit\">
    </p>
    <p>test:</p>
    <label for=\"f_wind_direction\">Wind Direction</label>
    <input type=\"text\" id=\"f_wind_direction\"/>
    <label for=\"f_seastate\">Seastate</label>
    <input type=\"text\" id=\"f_seastate\"/>
    <label for=\"f_wind_speed\">Wind Speed (Bft)</label>
    <input type=\"text\" id=\"f_wind_speed\"/>
</div>

";
        // line 70
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'form_end');
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
        return array (  147 => 70,  131 => 56,  123 => 54,  118 => 53,  114 => 52,  105 => 46,  101 => 45,  97 => 44,  86 => 36,  79 => 32,  75 => 31,  71 => 30,  60 => 22,  56 => 21,  52 => 20,  46 => 17,  36 => 10,  32 => 9,  23 => 3,  19 => 1,);
    }
}
