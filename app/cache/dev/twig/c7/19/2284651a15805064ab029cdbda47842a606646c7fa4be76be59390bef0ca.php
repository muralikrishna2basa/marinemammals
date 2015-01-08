<?php

/* AppBundle:Bare:list-observations.html.twig */
class __TwigTemplate_c7192284651a15805064ab029cdbda47842a606646c7fa4be76be59390bef0ca extends Twig_Template
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
        echo "    <h2>List of observations</h2>
    <table>
        <thead>
        <tr>
            <th>latitude</th>
            <th>longitude</th>
            <th>date and time</th>
            <th>specimen seqno</th>
        </tr>
        </thead>
        ";
        // line 11
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["observations"]) ? $context["observations"] : $this->getContext($context, "observations")));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["o"]) {
            // line 12
            echo "            <tr>
                <td>";
            // line 13
            echo twig_escape_filter($this->env, $this->getAttribute($context["o"], "latDeg", array()), "html", null, true);
            echo "</td>
                <td>";
            // line 14
            echo twig_escape_filter($this->env, $this->getAttribute($context["o"], "lonDeg", array()), "html", null, true);
            echo "</td>
                <td>";
            // line 15
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($this->getAttribute($context["o"], "eseSeqno", array()), "eventDatetime", array()), "m/d/Y"), "html", null, true);
            echo "</td>
                <td>";
            // line 16
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute($context["o"], "eseSeqno", array()), "spec2event", array()), "scnSeqno", array()), "txnSeqno", array()), "canonicalName", array()), "html", null, true);
            echo "</td>
            </tr>
        ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 19
            echo "            <tr>
                <td>No observations found.</td>
            </tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['o'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 23
        echo "    </table>";
    }

    public function getTemplateName()
    {
        return "AppBundle:Bare:list-observations.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  68 => 23,  59 => 19,  51 => 16,  47 => 15,  43 => 14,  39 => 13,  36 => 12,  31 => 11,  19 => 1,);
    }
}
