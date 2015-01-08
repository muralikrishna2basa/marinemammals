<?php

/* TaxaBundle:Bare:add.html.twig */
class __TwigTemplate_b6a22f74bfe93bdfe9de10983946017d65a4ef54008aa15171e2d3defc354ea5 extends Twig_Template
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
        echo "<h2>Add new Taxon</h2>
";
        // line 2
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'form_start', array("method" => "POST", "action" => $this->env->getExtension('routing')->getPath("mm_taxa_add_create")));
        echo "
<ul class=\"formelements\">
    <li>";
        // line 4
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "canonicalName", array()), 'row', array("label" => "Canonical name", "attr" => array("placeholder" => "e.g. Delphinus capensis")));
        echo "</li>
    <li>";
        // line 5
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "scientificNameAuthorship", array()), 'row', array("label" => "Authorship", "attr" => array("placeholder" => "e.g. Gray, 1828")));
        echo "</li>
    <li>";
        // line 6
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "vernacularNameEn", array()), 'row', array("label" => "Vernacular name", "attr" => array("placeholder" => "e.g. long-beaked common dolphin")));
        echo "</li>
    <li>";
        // line 7
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "taxonrank", array()), 'row', array("label" => "Taxon rank", "attr" => array("placeholder" => "e.g. species")));
        echo "</li>
    <li>";
        // line 8
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "idodId", array()), 'row', array("label" => "IDOD id", "attr" => array("placeholder" => "verify in IDOD, add there if needed")));
        echo "</li>
</ul>
<p>
    <input type=\"submit\" value=\"Submit\">
</p>
";
        // line 13
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'form_end');
        echo "

";
    }

    public function getTemplateName()
    {
        return "TaxaBundle:Bare:add.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  51 => 13,  43 => 8,  39 => 7,  35 => 6,  31 => 5,  27 => 4,  22 => 2,  19 => 1,);
    }
}
