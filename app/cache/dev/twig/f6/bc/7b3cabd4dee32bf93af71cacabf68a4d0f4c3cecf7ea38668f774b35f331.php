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
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'form_start', array("method" => "POST", "action" => $this->env->getExtension('routing')->getPath("mm_observations_add_create"), "attr" => array("id" => "observationform")));
        echo "
<ul class=\"nav nav-tabs\">
    <li class=\"tab\"><a href=\"#tabs-1\">Observation</a></li>
    <li class=\"tab\"><a href=\"#tabs-2\">Specimen</a></li>
    <li class=\"tab\"><a href=\"#tabs-3\">External pathology</a></li>
    <li class=\"tab\"><a href=\"#tabs-4\">Sources and media</a></li>
</ul>
<div class=\"well subformcontainer\">
    <p id=\"formerror\"></p>
    <fieldset id=\"tabs-1\">
        ";
        // line 11
        echo twig_include($this->env, $context, "AppBundle:Bare:add-observations.html.twig");
        echo "
        <h4><a class=\"next-tab ctl\" href=\"#\">NEXT</a></h4>
    </fieldset>
    <fieldset id=\"tabs-2\">
        ";
        // line 15
        echo twig_include($this->env, $context, "AppBundle:Bare:add-specimens.html.twig");
        echo "
        <h4><a class=\"prev-tab ctl\" href=\"#\">PREVIOUS</a></h4>
            <h4><a class=\"next-tab ctl\" href=\"#\">NEXT</a></h4>
    </fieldset>
    <fieldset id=\"tabs-3\" >
        ";
        // line 20
        echo twig_include($this->env, $context, "AppBundle:Bare:add-externalpathology.html.twig");
        echo "
        <h4><a class=\"prev-tab ctl\" href=\"#\">PREVIOUS </a></h4>
            <h4><a class=\"next-tab ctl\" href=\"#\">NEXT</a></h4>
    </fieldset>
    <fieldset id=\"tabs-4\">
        ";
        // line 25
        echo twig_include($this->env, $context, "AppBundle:Bare:add-sources-media.html.twig");
        echo "
        <h4><a class=\"prev-tab ctl\" href=\"#\">PREVIOUS</a></h4>
        <p>
            <input type=\"submit\" value=\"Submit\" id=\"submit\">
        </p>
    </fieldset>
</div>
";
        // line 32
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
        return array (  65 => 32,  55 => 25,  47 => 20,  39 => 15,  32 => 11,  19 => 1,);
    }
}
