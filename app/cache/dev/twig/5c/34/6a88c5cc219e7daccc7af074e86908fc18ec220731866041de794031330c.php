<?php

/* AppBundle:Bare:add-stations.html.twig */
class __TwigTemplate_5c346a88c5cc219e7daccc7af074e86908fc18ec220731866041de794031330c extends Twig_Template
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
        echo "<h2>Add new station</h2>
";
        // line 2
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["sform"]) ? $context["sform"] : $this->getContext($context, "sform")), 'form_start', array("method" => "POST", "action" => $this->env->getExtension('routing')->getPath("mm_stations_add_create")));
        echo "
<ul class=\"formelements\">
    <li>";
        // line 4
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["sform"]) ? $context["sform"] : $this->getContext($context, "sform")), "code", array()), 'row', array("label" => "Code"));
        echo "</li>
    <li>";
        // line 5
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["sform"]) ? $context["sform"] : $this->getContext($context, "sform")), "areaType", array()), 'row', array("label" => "Area type"));
        echo "</li>
    <li>";
        // line 6
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["sform"]) ? $context["sform"] : $this->getContext($context, "sform")), "description", array()), 'row', array("label" => "Description"));
        echo "</li>
    <li>";
        // line 7
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["sform"]) ? $context["sform"] : $this->getContext($context, "sform")), "latDeg", array()), 'row', array("label" => "Latitude"));
        echo "</li>
    <li>";
        // line 8
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["sform"]) ? $context["sform"] : $this->getContext($context, "sform")), "lonDeg", array()), 'row', array("label" => "Longitude"));
        echo "</li>
    <li>";
        // line 9
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["sform"]) ? $context["sform"] : $this->getContext($context, "sform")), "pceSeqno", array()), 'row', array("label" => "place"));
        echo "</li>
</ul>
<p>
    <input type=\"submit\" value=\"Submit\">
</p>
";
        // line 14
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["sform"]) ? $context["sform"] : $this->getContext($context, "sform")), 'form_end');
    }

    public function getTemplateName()
    {
        return "AppBundle:Bare:add-stations.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  55 => 14,  47 => 9,  43 => 8,  39 => 7,  35 => 6,  31 => 5,  27 => 4,  22 => 2,  19 => 1,);
    }
}
