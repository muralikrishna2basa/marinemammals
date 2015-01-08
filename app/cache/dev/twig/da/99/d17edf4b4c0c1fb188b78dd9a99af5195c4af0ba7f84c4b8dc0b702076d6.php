<?php

/* TaxaBundle:Bare:list.html.twig */
class __TwigTemplate_da99d17edf4b4c0c1fb188b78dd9a99af5195c4af0ba7f84c4b8dc0b702076d6 extends Twig_Template
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
        echo "    <h2>List of taxa</h2>
    <table>
        <thead>
        <tr>
            <th>Species</th>
            <th>Vernacular name</th>
            <th>Idod id</th>
        </tr>
        </thead>
        ";
        // line 10
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["taxa"]) ? $context["taxa"] : $this->getContext($context, "taxa")));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["taxon"]) {
            // line 11
            echo "            <tr>
                <td>";
            // line 12
            echo twig_escape_filter($this->env, $this->getAttribute($context["taxon"], "canonicalName", array()), "html", null, true);
            echo "</td>
                <td>";
            // line 13
            echo twig_escape_filter($this->env, $this->getAttribute($context["taxon"], "vernacularNameEn", array()), "html", null, true);
            echo "</td>
                <td>";
            // line 14
            echo twig_escape_filter($this->env, $this->getAttribute($context["taxon"], "idodId", array()), "html", null, true);
            echo "</td>
            </tr>
        ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 17
            echo "            <tr>
                <td>No taxa found.</td>
            </tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['taxon'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 21
        echo "    </table>";
    }

    public function getTemplateName()
    {
        return "TaxaBundle:Bare:list.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  63 => 21,  54 => 17,  46 => 14,  42 => 13,  38 => 12,  35 => 11,  30 => 10,  19 => 1,);
    }
}
