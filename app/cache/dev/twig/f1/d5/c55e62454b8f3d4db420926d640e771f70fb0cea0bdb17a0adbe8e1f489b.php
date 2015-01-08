<?php

/* AppBundle:Bare:list-stations.html.twig */
class __TwigTemplate_f1d5c55e62454b8f3d4db420926d640e771f70fb0cea0bdb17a0adbe8e1f489b extends Twig_Template
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
        echo "    <h2>List of stations</h2>
    <table>
        <thead>
        <tr>
            <th>code</th>
            <th>area type</th>
            <th>description</th>
            <th>latitude</th>
            <th>longitude</th>
            <th>place</th>
        </tr>
        </thead>
        ";
        // line 13
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["stations"]) ? $context["stations"] : $this->getContext($context, "stations")));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["station"]) {
            // line 14
            echo "            <tr>
                <td>";
            // line 15
            echo twig_escape_filter($this->env, $this->getAttribute($context["station"], "code", array()), "html", null, true);
            echo "</td>
                <td>";
            // line 16
            echo twig_escape_filter($this->env, $this->getAttribute($context["station"], "areaType", array()), "html", null, true);
            echo "</td>
                <td>";
            // line 17
            echo twig_escape_filter($this->env, $this->getAttribute($context["station"], "description", array()), "html", null, true);
            echo "</td>
                <td>";
            // line 18
            echo twig_escape_filter($this->env, $this->getAttribute($context["station"], "latDeg", array()), "html", null, true);
            echo "</td>
                <td>";
            // line 19
            echo twig_escape_filter($this->env, $this->getAttribute($context["station"], "lonDeg", array()), "html", null, true);
            echo "</td>
            </tr>
        ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 22
            echo "            <tr>
                <td>No stations found.</td>
            </tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['station'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 26
        echo "    </table>
";
    }

    public function getTemplateName()
    {
        return "AppBundle:Bare:list-stations.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  74 => 26,  65 => 22,  57 => 19,  53 => 18,  49 => 17,  45 => 16,  41 => 15,  38 => 14,  33 => 13,  19 => 1,);
    }
}
