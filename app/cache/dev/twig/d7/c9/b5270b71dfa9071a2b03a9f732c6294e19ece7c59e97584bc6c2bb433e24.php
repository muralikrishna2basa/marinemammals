<?php

/* AppBundle:Bare:list-persons.html.twig */
class __TwigTemplate_d7c9b5270b71dfa9071a2b03a9f732c6294e19ece7c59e97584bc6c2bb433e24 extends Twig_Template
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
        echo "    <h2>List of persons</h2>
    <table>
        <thead>
        <tr>
            <th>first name</th>
            <th>last name</th>
            <th>email</th>
        </tr>
        </thead>
        ";
        // line 10
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["persons"]) ? $context["persons"] : $this->getContext($context, "persons")));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["person"]) {
            // line 11
            echo "            <tr>
                <td>";
            // line 12
            echo twig_escape_filter($this->env, $this->getAttribute($context["person"], "firstName", array()), "html", null, true);
            echo "</td>
                <td>";
            // line 13
            echo twig_escape_filter($this->env, $this->getAttribute($context["person"], "lastName", array()), "html", null, true);
            echo "</td>
                <td>";
            // line 14
            echo twig_escape_filter($this->env, $this->getAttribute($context["person"], "email", array()), "html", null, true);
            echo "</td>
            </tr>
        ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 17
            echo "            <tr>
                <td>No persons found.</td>
            </tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['person'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 21
        echo "    </table>";
    }

    public function getTemplateName()
    {
        return "AppBundle:Bare:list-persons.html.twig";
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
