<?php

/* AppBundle:Page:list-observations.html.twig */
class __TwigTemplate_89c88e19d5c92d8bfcad3630c8ae6c748b9765cfcbb597e4ddb635cda62bf90c extends Twig_Template
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
        echo "    ";
        echo twig_include($this->env, $context, "AppBundle:Bare:list-observations.html.twig");
        echo "
";
    }

    public function getTemplateName()
    {
        return "AppBundle:Page:list-observations.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  31 => 4,  28 => 3,);
    }
}
