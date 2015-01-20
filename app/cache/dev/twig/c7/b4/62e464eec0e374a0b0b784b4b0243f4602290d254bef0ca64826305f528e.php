<?php

/* AppBundle:Bare:add-platforms.html.twig */
class __TwigTemplate_c7b462e464eec0e374a0b0b784b4b0243f4602290d254bef0ca64826305f528e extends Twig_Template
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
        echo "<h2>Add new platform</h2>
";
        // line 2
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'form_start', array("method" => "POST", "action" => $this->env->getExtension('routing')->getPath("mm_platforms_add_create")));
        echo "
<fieldset>
    <div class=\"form-inline\">";
        // line 4
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "name", array()), 'row', array("label" => "Name"));
        echo "</div>
    <div class=\"form-inline\">";
        // line 5
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "pfmType", array()), 'row', array("label" => "Platform type"));
        echo "</div>
</fieldset>
<p>
    <input type=\"submit\" value=\"Submit\">
</p>
";
        // line 10
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'form_end');
    }

    public function getTemplateName()
    {
        return "AppBundle:Bare:add-platforms.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  39 => 10,  31 => 5,  27 => 4,  22 => 2,  19 => 1,);
    }
}
