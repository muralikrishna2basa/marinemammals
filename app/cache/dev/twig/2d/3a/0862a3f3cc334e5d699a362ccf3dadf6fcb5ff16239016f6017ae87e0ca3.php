<?php

/* TaxaBundle:Page:add.html.twig */
class __TwigTemplate_2d3a0862a3f3cc334e5d699a362ccf3dadf6fcb5ff16239016f6017ae87e0ca3 extends Twig_Template
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
        echo "    <div class=\"col-lg-6\">    ";
        echo twig_include($this->env, $context, "TaxaBundle:Bare:add.html.twig");
        echo "</div>
    <div class=\"col-lg-6\">    ";
        // line 5
        echo twig_include($this->env, $context, "TaxaBundle:Bare:list.html.twig");
        echo "</div>
";
    }

    public function getTemplateName()
    {
        return "TaxaBundle:Page:add.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  36 => 5,  31 => 4,  28 => 3,);
    }
}
