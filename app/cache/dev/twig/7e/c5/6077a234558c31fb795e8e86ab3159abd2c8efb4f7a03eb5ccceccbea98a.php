<?php

/* AppBundle:Page:add-sources.html.twig */
class __TwigTemplate_7ec56077a234558c31fb795e8e86ab3159abd2c8efb4f7a03eb5ccceccbea98a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("AppBundle::nocol-layout.html.twig");

        $this->blocks = array(
            'main_content' => array($this, 'block_main_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "AppBundle::nocol-layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_main_content($context, array $blocks = array())
    {
        // line 4
        echo "    <div class=\"col-lg-6\">
        ";
        // line 5
        echo twig_include($this->env, $context, "AppBundle:Bare:add-sources.html.twig");
        echo "
       </div>
    <div class=\"col-lg-6\">    ";
        // line 7
        echo twig_include($this->env, $context, "AppBundle:Bare:list-sources.html.twig");
        echo "</div>
";
    }

    public function getTemplateName()
    {
        return "AppBundle:Page:add-sources.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  39 => 7,  34 => 5,  31 => 4,  28 => 3,);
    }
}