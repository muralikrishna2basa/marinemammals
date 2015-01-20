<?php

/* AppBundle:Bare:add-institutes.html.twig */
class __TwigTemplate_2185ad3544925829316823c1540fad273de1f1ba00537106c06eb85bd3fe2029 extends Twig_Template
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
        echo "<h2>Add new institute</h2>
";
        // line 2
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["iform"]) ? $context["iform"] : $this->getContext($context, "iform")), 'form_start', array("method" => "POST", "action" => $this->env->getExtension('routing')->getPath("mm_persons_add_create")));
        echo "
<fieldset>
    <div class=\"form-inline\">";
        // line 4
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["iform"]) ? $context["iform"] : $this->getContext($context, "iform")), "name", array()), 'row', array("label" => "Name"));
        echo "</div>
    <div class=\"form-inline\">";
        // line 5
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["iform"]) ? $context["iform"] : $this->getContext($context, "iform")), "code", array()), 'row', array("label" => "Code"));
        echo "</div>
</fieldset>
<p>
    <input type=\"submit\" value=\"Submit\">
</p>
";
        // line 10
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["iform"]) ? $context["iform"] : $this->getContext($context, "iform")), 'form_end');
    }

    public function getTemplateName()
    {
        return "AppBundle:Bare:add-institutes.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  39 => 10,  31 => 5,  27 => 4,  22 => 2,  19 => 1,);
    }
}
