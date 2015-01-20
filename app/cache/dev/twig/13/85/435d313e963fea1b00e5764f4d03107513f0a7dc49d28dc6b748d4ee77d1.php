<?php

/* AppBundle:Page:add-persons.html.twig */
class __TwigTemplate_1385435d313e963fea1b00e5764f4d03107513f0a7dc49d28dc6b748d4ee77d1 extends Twig_Template
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
        echo twig_include($this->env, $context, "AppBundle:Bare:add-persons.html.twig");
        echo "
        ";
        // line 5
        echo twig_include($this->env, $context, "AppBundle:Bare:add-institutes.html.twig");
        echo "
       </div>
    <div class=\"col-lg-6\">    ";
        // line 7
        echo twig_include($this->env, $context, "AppBundle:Bare:list-persons.html.twig");
        echo "</div>
";
    }

    public function getTemplateName()
    {
        return "AppBundle:Page:add-persons.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  43 => 7,  38 => 5,  34 => 4,  31 => 3,  28 => 2,);
    }
}
