<?php

/* AppBundle:Bare:add-events.html.twig */
class __TwigTemplate_ade4aafa06ec60044a3d01321ee97d5a65875fb31d721f588454449f2ac536e7 extends Twig_Template
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
        echo "<div style=\" margin-top:2em;border:2px solid darkorange;\">
    <h2>Observation</h2>
";
        // line 3
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'form_start', array("method" => "POST", "action" => $this->env->getExtension('routing')->getPath("mm_events_add_create")));
        echo "
    <ul class=\"formelements\" id=\"observation_elements\">
        <li>
            <h3>Date and time</h3>
            <ul>
                <li><label for=\"f_date\">Date</label><input type=\"text\" id=\"f_date\"/>
                    <label for=\"f_time\">Time</label>
                    <input type=\"text\" id=\"f_time\"/>
                    <label for=\"f_datetime_flag\">Date flag</label>
                    <select id=\"f_datetime_flag\">
                        <option>Select or leave empty...</option>
                        <option>reference unknown</option>
                        <option>time unknown</option>
                        <option>replaced</option>
                        <option>date suspect</option>
                        <option>time suspect</option>
                        <option>missing</option>
                    </select></li>
            </ul>
        </li>
        <li>
            <h3>Observation comments</h3>
            <ul>
                <li><label for=\"f_event_description\">Observation description</label>
                    <input type=\"text\" id=\"f_event_description\"/></li>
                <li><label for=\"f_webcomments_en\">Web Comments: English</label>
                    <input type=\"text\" id=\"f_webcomments_en\"/>
                    <label for=\"f_webcomments_nl\">Web Comments: Dutch</label>
                    <input type=\"text\" id=\"f_webcomments_nl\"/>
                    <label for=\"f_webcomments_fr\">Web Comments: French</label>
                    <input type=\"text\" id=\"f_webcomments_fr\"/></li>
            </ul>
        </li>
    </ul>
    <p>
        <input type=\"submit\" value=\"Submit\">
    </p>
</div>

";
        // line 42
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'form_end');
    }

    public function getTemplateName()
    {
        return "AppBundle:Bare:add-events.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  65 => 42,  23 => 3,  19 => 1,);
    }
}
