<?php

/* AppBundle:Page:add-platforms.html.twig */
class __TwigTemplate_db62a33f5985f46ff3e7cd83c650bbcea1c8cf1053025c1f811099c2fb559734 extends Twig_Template
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

    // line 2
    public function block_main_content($context, array $blocks = array())
    {
        // line 3
        echo "    <div class=\"col-lg-6\">
        ";
        // line 4
        echo twig_include($this->env, $context, "AppBundle:Bare:add-platforms.html.twig");
        echo "
       </div>
    <div class=\"col-lg-6\">    ";
        // line 6
        echo twig_include($this->env, $context, "AppBundle:Bare:list-platforms.html.twig");
        echo "</div>
";
    }

    public function getTemplateName()
    {
        return "AppBundle:Page:add-platforms.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  39 => 6,  34 => 4,  31 => 3,  28 => 2,);
    }
}
