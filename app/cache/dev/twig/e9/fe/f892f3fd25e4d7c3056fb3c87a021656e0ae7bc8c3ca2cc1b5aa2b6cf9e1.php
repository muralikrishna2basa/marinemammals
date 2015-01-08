<?php

/* AppBundle:Bare:add-persons.html.twig */
class __TwigTemplate_e9fef892f3fd25e4d7c3056fb3c87a021656e0ae7bc8c3ca2cc1b5aa2b6cf9e1 extends Twig_Template
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
        echo "<h2>Add new person</h2>
";
        // line 2
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["pform"]) ? $context["pform"] : $this->getContext($context, "pform")), 'form_start', array("method" => "POST", "action" => $this->env->getExtension('routing')->getPath("mm_persons_add_create")));
        echo "
<ul class=\"formelements\">
    <li>";
        // line 4
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["pform"]) ? $context["pform"] : $this->getContext($context, "pform")), "firstName", array()), 'row', array("label" => "First name"));
        echo "</li>
    <li>";
        // line 5
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["pform"]) ? $context["pform"] : $this->getContext($context, "pform")), "lastName", array()), 'row', array("label" => "Last name"));
        echo "</li>
    <li>";
        // line 6
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["pform"]) ? $context["pform"] : $this->getContext($context, "pform")), "address", array()), 'row', array("label" => "Address", "attr" => array("placeholder" => "<street> <streetnumber>, <postal code> <municipality>")));
        echo "</li>
    <li>";
        // line 7
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["pform"]) ? $context["pform"] : $this->getContext($context, "pform")), "iteSeqno", array()), 'row', array("label" => "Institute"));
        echo "</li>
    <li>";
        // line 8
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["pform"]) ? $context["pform"] : $this->getContext($context, "pform")), "phoneNumber", array()), 'row', array("label" => "Phone number", "attr" => array("placeholder" => "dd(d)(d)/dddddd(d)")));
        echo "</li>
    <li>";
        // line 9
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["pform"]) ? $context["pform"] : $this->getContext($context, "pform")), "email", array()), 'row', array("label" => "mail"));
        echo "</li>
    <li>";
        // line 10
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["pform"]) ? $context["pform"] : $this->getContext($context, "pform")), "sex", array()), 'row', array("label" => "Sex"));
        echo "</li>
    <li>";
        // line 11
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["pform"]) ? $context["pform"] : $this->getContext($context, "pform")), "title", array()), 'row', array("label" => "Title"));
        echo "</li>
    <li>";
        // line 12
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["pform"]) ? $context["pform"] : $this->getContext($context, "pform")), "idodId", array()), 'row', array("label" => "IDOD id", "attr" => array("placeholder" => "verify in IDOD, add there if needed")));
        echo "</li>
</ul>
<p>
    <input type=\"submit\" value=\"Submit\">
</p>
";
        // line 17
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["pform"]) ? $context["pform"] : $this->getContext($context, "pform")), 'form_end');
        echo "
";
    }

    public function getTemplateName()
    {
        return "AppBundle:Bare:add-persons.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  67 => 17,  59 => 12,  55 => 11,  51 => 10,  47 => 9,  43 => 8,  39 => 7,  35 => 6,  31 => 5,  27 => 4,  22 => 2,  19 => 1,);
    }
}
