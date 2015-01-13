<?php

/* AppBundle:Bare:add-observations-specimens.html.twig */
class __TwigTemplate_f6bc7b3cabd4dee32bf93af71cacabf68a4d0f4c3cecf7ea38668f774b35f331 extends Twig_Template
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
<fieldset>
    ";
        // line 3
        echo twig_include($this->env, $context, "AppBundle:Bare:add-observations.html.twig");
        echo "
</fieldset>
<fieldset>
    ";
        // line 6
        echo twig_include($this->env, $context, "AppBundle:Bare:add-specimens.html.twig");
        echo "
</fieldset>
<p>
    <input type=\"submit\" value=\"Submit\">
</p>
";
        // line 11
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'form_end');
        echo "

";
    }

    public function getTemplateName()
    {
        return "AppBundle:Bare:add-observations-specimens.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  38 => 11,  30 => 6,  24 => 3,  19 => 1,);
    }
}
