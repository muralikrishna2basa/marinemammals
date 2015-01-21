<?php

/* AppBundle:Bare:add-sources-media.html.twig */
class __TwigTemplate_e24780edccf376b1b552475948881f76a0d24335ca803c56a6a73469567fbfe4 extends Twig_Template
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
        echo "<legend>Sources and media</legend>

<h3>Sources</h3>

<div class=\"form-inline\">
    ";
        // line 6
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "singleSource", array()), 'row', array("label" => "Source"));
        echo "
</div>
<div class=\"form-inline\">
    ";
        // line 9
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "pfmSeqno", array()), 'row', array("label" => "Platform"));
        echo "
</div>
<h4>Observed by</h4>
<ul class=\"e2p_observer\" data-prototype=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "observers", array()), "vars", array()), "prototype", array()), 'widget'));
        echo "\">
    ";
        // line 13
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "observers", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["e2p_observer"]) {
            // line 14
            echo "        <li class=\"form-inline\">
            ";
            // line 15
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($context["e2p_observer"], "psnSeqno", array()), 'row', array("label" => "Person"));
            echo "
        </li>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['e2p_observer'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 18
        echo "</ul>
<h4>Gathered by</h4>
<ul class=\"e2p_gatherer\" data-prototype=\"";
        // line 20
        echo twig_escape_filter($this->env, $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "gatherers", array()), "vars", array()), "prototype", array()), 'widget'));
        echo "\">
    ";
        // line 21
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "eseSeqno", array()), "gatherers", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["e2p_gatherer"]) {
            // line 22
            echo "        <li class=\"form-inline\">
            ";
            // line 23
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($context["e2p_gatherer"], "psnSeqno", array()), 'row', array("label" => "Person"));
            echo "
        </li>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['e2p_gatherer'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 26
        echo "</ul>
<h3>Media</h3>
";
    }

    public function getTemplateName()
    {
        return "AppBundle:Bare:add-sources-media.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  82 => 26,  73 => 23,  70 => 22,  66 => 21,  62 => 20,  58 => 18,  49 => 15,  46 => 14,  42 => 13,  38 => 12,  32 => 9,  26 => 6,  19 => 1,);
    }
}
