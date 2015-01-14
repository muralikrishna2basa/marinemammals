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
        echo "    <h2>Specimen</h2>
    <h3>Search or enter existing specimen</h3>
    <div class=\"form-inline\">
        <button id=\"b_search_scn\">Search for specimen in list</button>
        <label for=\"q_scn_seqno\">Specimen id</label>
        <input type=\"text\" id=\"q_scn_seqno\"/>
    </div>
    <h3>Identification</h3>
    <div class=\"form-inline\">
        ";
        // line 10
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "spec2event", array()), "scnSeqno", array()), "txnSeqno", array()), 'row', array("label" => "Species"));
        echo "
    </div>
    <div class=\"form-inline\">
        ";
        // line 13
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "spec2event", array()), "scnSeqno", array()), "specieFlag", array()), 'row', array("label" => "Identification is certain?"));
        echo "
    </div>
    <div class=\"form-inline\">
        ";
        // line 16
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "spec2event", array()), "scnSeqno", array()), "scnNumber", array()), 'row', array("label" => "Number"));
        echo "
    </div>
    <div class=\"form-inline\">
        ";
        // line 19
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "spec2event", array()), "scnSeqno", array()), "sex", array()), 'row', array("label" => "Sex"));
        echo "
    </div>
    <div class=\"form-inline\">
        ";
        // line 22
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "spec2event", array()), "scnSeqno", array()), "rbinsTag", array()), 'row', array("label" => "RBINS tag"));
        echo "
    </div>
    <div class=\"form-inline\">
        ";
        // line 25
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "spec2event", array()), "scnSeqno", array()), "necropsyTag", array()), 'row', array("label" => "Necropsy tag"));
        echo "
    </div>

    <h3>Circumstantial parameters</h3>
    ";
        // line 29
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable(twig_slice($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "spec2event", array()), "values", array()), 0, 4));
        foreach ($context['_seq'] as $context["_key"] => $context["sv"]) {
            // line 30
            echo "        <h4>";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["sv"], "vars", array()), "value", array()), "pmdName", array()), "html", null, true);
            echo "</h4>
        <div class=\"form-inline\">";
            // line 31
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($context["sv"], "value", array()), 'row', array("label" => "Value"));
            echo "
            ";
            // line 32
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($context["sv"], "valueFlag", array()), 'row', array("label" => "Value flag"));
            echo "</div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['sv'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 34
        echo "    <h3>Measurements</h3>
    ";
        // line 35
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable(twig_slice($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "spec2event", array()), "values", array()), 4, 8));
        foreach ($context['_seq'] as $context["_key"] => $context["sv"]) {
            // line 36
            echo "        <h4>";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["sv"], "vars", array()), "value", array()), "pmdName", array()), "html", null, true);
            echo "</h4>
        <div class=\"form-inline\">";
            // line 37
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($context["sv"], "value", array()), 'row', array("label" => "Value"));
            echo "
            ";
            // line 38
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($context["sv"], "valueFlag", array()), 'row', array("label" => "Value flag"));
            echo "</div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['sv'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 40
        echo "



";
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
        return array (  112 => 40,  104 => 38,  100 => 37,  95 => 36,  91 => 35,  88 => 34,  80 => 32,  76 => 31,  71 => 30,  67 => 29,  60 => 25,  54 => 22,  48 => 19,  42 => 16,  36 => 13,  30 => 10,  19 => 1,);
    }
}
