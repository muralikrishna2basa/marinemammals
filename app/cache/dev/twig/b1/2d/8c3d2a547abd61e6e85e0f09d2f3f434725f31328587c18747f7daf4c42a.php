<?php

/* AppBundle:Bare:list-platforms.html.twig */
class __TwigTemplate_b12d8c3d2a547abd61e6e85e0f09d2f3f434725f31328587c18747f7daf4c42a extends Twig_Template
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
        echo "    <h2>List of platforms</h2>
    <table>
        <thead>
        <tr>
            <th>name</th>
            <th>type</th>
        </tr>
        </thead>
        ";
        // line 9
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["platforms"]) ? $context["platforms"] : $this->getContext($context, "platforms")));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["p"]) {
            // line 10
            echo "            <tr>
                <td>";
            // line 11
            echo twig_escape_filter($this->env, $this->getAttribute($context["p"], "name", array()), "html", null, true);
            echo "</td>
                <td>";
            // line 12
            echo twig_escape_filter($this->env, $this->getAttribute($context["p"], "pfmType", array()), "html", null, true);
            echo "</td>
            </tr>
        ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 15
            echo "            <tr>
                <td>No platforms found.</td>
            </tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['p'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 19
        echo "    </table>";
    }

    public function getTemplateName()
    {
        return "AppBundle:Bare:list-platforms.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  58 => 19,  49 => 15,  41 => 12,  37 => 11,  34 => 10,  29 => 9,  19 => 1,);
    }
}
