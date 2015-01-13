<?php

/* bootstrap_3_horizontal_layout.html.twig */
class __TwigTemplate_7da0d1b02433bdc83c66251bb7357edc214159e4c971c29004c3a0efcf9702a3 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("bootstrap_3_layout.html.twig");

        $this->blocks = array(
            'form_start' => array($this, 'block_form_start'),
            'form_label' => array($this, 'block_form_label'),
            'form_label_class' => array($this, 'block_form_label_class'),
            'form_row' => array($this, 'block_form_row'),
            'checkbox_row' => array($this, 'block_checkbox_row'),
            'radio_row' => array($this, 'block_radio_row'),
            'checkbox_radio_row' => array($this, 'block_checkbox_radio_row'),
            'submit_row' => array($this, 'block_submit_row'),
            'form_group_class' => array($this, 'block_form_group_class'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "bootstrap_3_layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_form_start($context, array $blocks = array())
    {
        // line 4
        $context["attr"] = twig_array_merge((isset($context["attr"]) ? $context["attr"] : $this->getContext($context, "attr")), array("class" => trim(((($this->getAttribute((isset($context["attr"]) ? $context["attr"] : null), "class", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["attr"]) ? $context["attr"] : null), "class", array()), "")) : ("")) . " form-horizontal"))));
        // line 5
        $this->displayParentBlock("form_start", $context, $blocks);
    }

    // line 10
    public function block_form_label($context, array $blocks = array())
    {
        // line 11
        ob_start();
        // line 12
        echo "    ";
        if (((isset($context["label"]) ? $context["label"] : $this->getContext($context, "label")) === false)) {
            // line 13
            echo "        <div class=\"";
            $this->displayBlock("form_label_class", $context, $blocks);
            echo "\"></div>
    ";
        } else {
            // line 15
            echo "        ";
            $context["label_attr"] = twig_array_merge((isset($context["label_attr"]) ? $context["label_attr"] : $this->getContext($context, "label_attr")), array("class" => trim((((($this->getAttribute((isset($context["label_attr"]) ? $context["label_attr"] : null), "class", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["label_attr"]) ? $context["label_attr"] : null), "class", array()), "")) : ("")) . " ") . $this->renderBlock("form_label_class", $context, $blocks)))));
            // line 16
            $this->displayParentBlock("form_label", $context, $blocks);
        }
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
    }

    // line 21
    public function block_form_label_class($context, array $blocks = array())
    {
        // line 22
        echo "col-sm-2";
    }

    // line 27
    public function block_form_row($context, array $blocks = array())
    {
        // line 28
        ob_start();
        // line 29
        echo "    <div class=\"form-group";
        if ((((!(isset($context["compound"]) ? $context["compound"] : $this->getContext($context, "compound"))) || ((array_key_exists("force_error", $context)) ? (_twig_default_filter((isset($context["force_error"]) ? $context["force_error"] : $this->getContext($context, "force_error")), false)) : (false))) && (!(isset($context["valid"]) ? $context["valid"] : $this->getContext($context, "valid"))))) {
            echo " has-error";
        }
        echo "\">
        ";
        // line 30
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'label');
        echo "
        <div class=\"";
        // line 31
        $this->displayBlock("form_group_class", $context, $blocks);
        echo "\">
            ";
        // line 32
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'widget');
        echo "
            ";
        // line 33
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'errors');
        echo "
        </div>
    </div>
";
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
    }

    // line 39
    public function block_checkbox_row($context, array $blocks = array())
    {
        // line 40
        $this->displayBlock("checkbox_radio_row", $context, $blocks);
    }

    // line 43
    public function block_radio_row($context, array $blocks = array())
    {
        // line 44
        $this->displayBlock("checkbox_radio_row", $context, $blocks);
    }

    // line 47
    public function block_checkbox_radio_row($context, array $blocks = array())
    {
        // line 48
        ob_start();
        // line 49
        echo "    <div class=\"form-group";
        if ((!(isset($context["valid"]) ? $context["valid"] : $this->getContext($context, "valid")))) {
            echo " has-error";
        }
        echo "\">
        <div class=\"";
        // line 50
        $this->displayBlock("form_label_class", $context, $blocks);
        echo "\"></div>
        <div class=\"";
        // line 51
        $this->displayBlock("form_group_class", $context, $blocks);
        echo "\">
            ";
        // line 52
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'widget');
        echo "
            ";
        // line 53
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'errors');
        echo "
        </div>
    </div>
";
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
    }

    // line 59
    public function block_submit_row($context, array $blocks = array())
    {
        // line 60
        ob_start();
        // line 61
        echo "    <div class=\"form-group\">
        <div class=\"";
        // line 62
        $this->displayBlock("form_label_class", $context, $blocks);
        echo "\"></div>
        <div class=\"";
        // line 63
        $this->displayBlock("form_group_class", $context, $blocks);
        echo "\">
            ";
        // line 64
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'widget');
        echo "
        </div>
    </div>
";
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
    }

    // line 70
    public function block_form_group_class($context, array $blocks = array())
    {
        // line 71
        echo "col-sm-10";
    }

    public function getTemplateName()
    {
        return "bootstrap_3_horizontal_layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  183 => 71,  180 => 70,  171 => 64,  167 => 63,  163 => 62,  160 => 61,  158 => 60,  155 => 59,  146 => 53,  142 => 52,  138 => 51,  134 => 50,  127 => 49,  125 => 48,  122 => 47,  118 => 44,  115 => 43,  111 => 40,  108 => 39,  99 => 33,  95 => 32,  91 => 31,  87 => 30,  80 => 29,  78 => 28,  75 => 27,  71 => 22,  68 => 21,  62 => 16,  59 => 15,  53 => 13,  50 => 12,  48 => 11,  45 => 10,  41 => 5,  39 => 4,  36 => 3,);
    }
}
