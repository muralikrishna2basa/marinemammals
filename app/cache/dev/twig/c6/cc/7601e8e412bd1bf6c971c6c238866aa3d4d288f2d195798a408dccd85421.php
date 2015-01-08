<?php

/* AppBundle:Bare:list-sources.html.twig */
class __TwigTemplate_c6cc7601e8e412bd1bf6c971c6c238866aa3d4d288f2d195798a408dccd85421 extends Twig_Template
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
        echo "    <h2>List of sources</h2>
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
        $context['_seq'] = twig_ensure_traversable((isset($context["sources"]) ? $context["sources"] : $this->getContext($context, "sources")));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["s"]) {
            // line 10
            echo "            <tr>
                <td>";
            // line 11
            echo twig_escape_filter($this->env, $this->getAttribute($context["s"], "name", array()), "html", null, true);
            echo "</td>
                <td>";
            // line 12
            echo twig_escape_filter($this->env, $this->getAttribute($context["s"], "type", array()), "html", null, true);
            echo "</td>
            </tr>
        ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 15
            echo "            <tr>
                <td>No sources found.</td>
            </tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['s'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 19
        echo "    </table>";
    }

    public function getTemplateName()
    {
        return "AppBundle:Bare:list-sources.html.twig";
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
