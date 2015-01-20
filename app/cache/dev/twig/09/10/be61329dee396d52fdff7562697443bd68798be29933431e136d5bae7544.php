<?php

/* AppBundle:Page:add-stations.html.twig */
class __TwigTemplate_0910be61329dee396d52fdff7562697443bd68798be29933431e136d5bae7544 extends Twig_Template
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
        echo twig_include($this->env, $context, "AppBundle:Bare:add-stations.html.twig");
        echo "
        ";
        // line 5
        echo twig_include($this->env, $context, "AppBundle:Bare:add-places.html.twig");
        echo "
       </div>
    <div class=\"col-lg-6\">    ";
        // line 7
        echo twig_include($this->env, $context, "AppBundle:Bare:list-stations.html.twig");
        echo "</div>
";
    }

    public function getTemplateName()
    {
        return "AppBundle:Page:add-stations.html.twig";
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
