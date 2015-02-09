<?php

/* AppBundle:Bare:add-externalpathology.html.twig */
class __TwigTemplate_972c70d7f7a4ba63029eb0c8cfc2e7a6e22bb5064ce8a2f9c38d95c74dffb7c5 extends Twig_Template
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
        echo "<fieldset id=\"pathology_values\" class=\"no-multi\">
    <legend><h2>External pathology</h2></legend>
    <fieldset>
        <legend><h3>Fresh external lesions</h3></legend>
        <div class=\"form-inline\">";
        // line 5
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable(twig_slice($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "spec2events", array()), "pathologyValues", array()), 0, 9));
        foreach ($context['_seq'] as $context["_key"] => $context["sv"]) {
            // line 6
            echo "            ";
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($context["sv"], "value", array()), 'row', array("label" => twig_last($this->env, twig_split_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["sv"], "vars", array()), "value", array()), "pmdName", array()), "::")), "attr" => array("class" => "form-inline")));
            echo "
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['sv'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 7
        echo "</div>
        <fieldset>
            <legend><h4>Line/net impressions or cuts</h4></legend>
            <div class=\"form-inline\">";
        // line 10
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable(twig_slice($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "spec2events", array()), "pathologyValues", array()), 9, 4));
        foreach ($context['_seq'] as $context["_key"] => $context["sv"]) {
            // line 11
            echo "                ";
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($context["sv"], "value", array()), 'row', array("label" => twig_last($this->env, twig_split_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["sv"], "vars", array()), "value", array()), "pmdName", array()), "::")), "attr" => array("class" => "form-inline")));
            echo "
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['sv'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 12
        echo "</div>
        </fieldset>
        <fieldset>
            <legend><h4>Scavenger traces</h4></legend>
            <div class=\"form-inline\">";
        // line 16
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable(twig_slice($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "spec2events", array()), "pathologyValues", array()), 13, 2));
        foreach ($context['_seq'] as $context["_key"] => $context["sv"]) {
            // line 17
            echo "                ";
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($context["sv"], "value", array()), 'row', array("label" => twig_last($this->env, twig_split_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["sv"], "vars", array()), "value", array()), "pmdName", array()), "::")), "attr" => array("class" => "form-inline")));
            echo "
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['sv'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 18
        echo "</div>
        </fieldset>
    </fieldset>
    <fieldset>
        <legend><h3>Healing/healed lesions</h3></legend>
        <div class=\"form-inline\">";
        // line 23
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable(twig_slice($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "spec2events", array()), "pathologyValues", array()), 15, 5));
        foreach ($context['_seq'] as $context["_key"] => $context["sv"]) {
            // line 24
            echo "            ";
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($context["sv"], "value", array()), 'row', array("label" => twig_last($this->env, twig_split_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["sv"], "vars", array()), "value", array()), "pmdName", array()), "::")), "attr" => array("class" => "form-inline")));
            echo "
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['sv'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 25
        echo "</div>
    </fieldset>
    <fieldset>
        <legend><h3>Fishing activities</h3></legend>
        <div class=\"form-inline\">";
        // line 29
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable(twig_slice($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "spec2events", array()), "pathologyValues", array()), 20, 2));
        foreach ($context['_seq'] as $context["_key"] => $context["sv"]) {
            // line 30
            echo "            ";
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($context["sv"], "value", array()), 'row', array("label" => twig_last($this->env, twig_split_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["sv"], "vars", array()), "value", array()), "pmdName", array()), "::")), "attr" => array("class" => "form-inline")));
            echo "
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['sv'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 31
        echo "</div>
    </fieldset>
    <fieldset>
        <legend><h3>Other characteristics</h3></legend>
        <div class=\"form-inline\">";
        // line 35
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable(twig_slice($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "spec2events", array()), "pathologyValues", array()), 22, 9));
        foreach ($context['_seq'] as $context["_key"] => $context["sv"]) {
            // line 36
            echo "            ";
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($context["sv"], "value", array()), 'row', array("label" => twig_last($this->env, twig_split_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["sv"], "vars", array()), "value", array()), "pmdName", array()), "::")), "attr" => array("class" => "form-inline")));
            echo "
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['sv'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 37
        echo "</div>
    </fieldset>
</fieldset>";
    }

    public function getTemplateName()
    {
        return "AppBundle:Bare:add-externalpathology.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  133 => 37,  124 => 36,  120 => 35,  114 => 31,  105 => 30,  101 => 29,  95 => 25,  86 => 24,  82 => 23,  75 => 18,  66 => 17,  62 => 16,  56 => 12,  47 => 11,  43 => 10,  38 => 7,  29 => 6,  25 => 5,  19 => 1,);
    }
}
