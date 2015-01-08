<?php

/* AppBundle::nocol-layout.html.twig */
class __TwigTemplate_5a2f89072b32d29fe1772aab1688da41fe1492ebd5c93d848dc06394795848c6 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("::base.html.twig");

        $this->blocks = array(
            'main_content' => array($this, 'block_main_content'),
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

    // line 4
    public function block_main_content($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "AppBundle::nocol-layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  28 => 4,);
    }
}
