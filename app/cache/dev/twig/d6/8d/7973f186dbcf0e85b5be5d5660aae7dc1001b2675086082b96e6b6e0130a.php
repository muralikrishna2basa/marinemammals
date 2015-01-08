<?php

/* AppBundle::col-layout.html.twig */
class __TwigTemplate_d68d7973f186dbcf0e85b5be5d5660aae7dc1001b2675086082b96e6b6e0130a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("::base.html.twig");

        $this->blocks = array(
            'main_content' => array($this, 'block_main_content'),
            'mainbar' => array($this, 'block_mainbar'),
            'sidebar' => array($this, 'block_sidebar'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_main_content($context, array $blocks = array())
    {
        // line 3
        echo "<div class=\"col-md-9\">";
        $this->displayBlock('mainbar', $context, $blocks);
        echo "</div>
<aside>
\t<div class=\"col-md-3\">";
        // line 5
        $this->displayBlock('sidebar', $context, $blocks);
        echo "</div>
</aside>
";
    }

    // line 3
    public function block_mainbar($context, array $blocks = array())
    {
    }

    // line 5
    public function block_sidebar($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "AppBundle::col-layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  51 => 5,  46 => 3,  39 => 5,  33 => 3,  30 => 2,);
    }
}
