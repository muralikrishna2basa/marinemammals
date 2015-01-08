<?php

/* AppBundle:Bare:add-places.html.twig */
class __TwigTemplate_6fe32ddd429128d1260743d6066b9e7df02665859e6f7e91d6216666f92a1771 extends Twig_Template
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
        echo "<h2>Add new place</h2>
";
        // line 2
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["pform"]) ? $context["pform"] : $this->getContext($context, "pform")), 'form_start', array("method" => "POST", "action" => $this->env->getExtension('routing')->getPath("mm_persons_add_create")));
        echo "
<ul class=\"formelements\">
    <li>";
        // line 4
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["pform"]) ? $context["pform"] : $this->getContext($context, "pform")), "name", array()), 'row', array("label" => "Name"));
        echo "</li>
    <li>";
        // line 5
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["pform"]) ? $context["pform"] : $this->getContext($context, "pform")), "type", array()), 'row', array("label" => "Type"));
        echo "</li>
    <li>";
        // line 6
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["pform"]) ? $context["pform"] : $this->getContext($context, "pform")), "pceSeqno", array()), 'row', array("label" => "Place"));
        echo "</li>
</ul>
<p>
    <input type=\"submit\" value=\"Submit\">
</p>
";
        // line 11
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["pform"]) ? $context["pform"] : $this->getContext($context, "pform")), 'form_end');
        echo "

";
    }

    public function getTemplateName()
    {
        return "AppBundle:Bare:add-places.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  43 => 11,  35 => 6,  31 => 5,  27 => 4,  22 => 2,  19 => 1,);
    }
}
