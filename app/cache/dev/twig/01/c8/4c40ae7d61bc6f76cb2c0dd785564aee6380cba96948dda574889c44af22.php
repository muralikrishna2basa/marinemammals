<?php

/* ::base.html.twig */
class __TwigTemplate_01c84c40ae7d61bc6f76cb2c0dd785564aee6380cba96948dda574889c44af22 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'navigation' => array($this, 'block_navigation'),
            'main_content' => array($this, 'block_main_content'),
            'footer' => array($this, 'block_footer'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!-- app/Resources/views/base.html.twig -->
<!DOCTYPE html>
<html>
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html\" charset=utf-8 \" />
<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
<meta name=\"description\" content=\"Marine Mammals\">
<meta name=\"author\" content=\"Thomas Vandenberghe\">
<title>";
        // line 9
        $this->displayBlock('title', $context, $blocks);
        echo "Marine Mammals</title>
<link rel=\"shortcut icon\"
\thref=\"http://www.odnature.be/assets/nav/logos/logo32x32.ico\" />
<!--[if lt IE 9]>
\t\t<script src=\"https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js\"></script>
\t\t<script src=\"https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js\"></script>
    <![endif]-->
";
        // line 16
        if (isset($context['assetic']['debug']) && $context['assetic']['debug']) {
            // asset "24fb7a2_0"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_24fb7a2_0") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/24fb7a2_css?family=PT+Sans:400,400italic,700,700italic|Patua+One|Yanone+Kaffeesatz_1.css");
            // line 21
            echo "    <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\" />
";
            // asset "24fb7a2_1"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_24fb7a2_1") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/24fb7a2_font-awesome_2.css");
            echo "    <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\" />
";
            // asset "24fb7a2_2"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_24fb7a2_2") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/24fb7a2_odnature_3.css");
            echo "    <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\" />
";
            // asset "24fb7a2_3"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_24fb7a2_3") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/24fb7a2_mm_4.css");
            echo "    <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\" />
";
        } else {
            // asset "24fb7a2"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_24fb7a2") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/24fb7a2.css");
            echo "    <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\" />
";
        }
        unset($context["asset_url"]);
        // line 23
        echo "
</head>
<body>
\t<div class=\"container\">
\t\t<header>
\t\t\t<div class=\"top-links\">
\t\t\t\t<a href=\"http://www.naturalsciences.be/\">museum</a><span class=\"sep\">&#187;</span>
\t\t\t\t<a href=\"http://www.naturalsciences.be/en/science/home\">science</a><span
\t\t\t\t\tclass=\"sep\">&#187;</span> <a
\t\t\t\t\thref=\"http://www.naturalsciences.be/en/science/do/98\">od nature</a><span
\t\t\t\t\tclass=\"sep\">&#187;</span> <a href=\"http://www.odnature.be/\">scientific
\t\t\t\t\tweb sites and applications</a>
\t\t\t</div>
\t\t\t<div class=\"top-links\">
\t\t\t\t<form class=\"form-inline top-search\" role=\"form\">
\t\t\t\t\t<div class=\"form-group\"></div>
\t\t\t\t</form>
\t\t\t</div>
\t\t\t<div class=\"branding-main\">
\t\t\t\t<div class=\"branding-logo\">
\t\t\t\t\t<img src=\"http://www.odnature.be/assets/nav/logos/museum.png\" alt=\"logo\" />
\t\t\t\t</div>
\t\t\t\t<div class=\"branding-text\">
\t\t\t\t\t<span class=\"institution\">Royal Belgian Institute of Natural
\t\t\t\t\t\tSciences</span>
\t\t\t\t\t<p class=\"directorate\">
\t\t\t\t\t\tOperational Directorate Natural Environment<br /> <span
\t\t\t\t\t\t\tclass=\"swap-branding\">scientific web sites and applications</span>
\t\t\t\t\t</p>
\t\t\t\t</div>
\t\t\t</div>
\t\t\t<div class=\"navmenu\">
\t\t\t <nav class=\"navbar navbar-default\" role=\"navigation\">
\t\t\t\t";
        // line 56
        $this->displayBlock('navigation', $context, $blocks);
        // line 101
        echo "\t\t\t</nav>
\t\t\t</div>
\t\t\t<div class=\"showcase hidden-print\">
    \t\t\t<img src=\"";
        // line 104
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("img/seals.jpg"), "html", null, true);
        echo "\" alt=\"photo banner\" />
\t\t\t\t<div class=\"tagline\">
\t\t\t\t\t<span class=\"acronym\">Belgian Marine Mammals</span>
\t\t\t\t\t<p class=\"description\">OD Nature Belgian Marine Data Center</p>
\t\t\t\t</div>
\t\t\t</div>
\t\t\t<div class=\"showcase-mobile\">
\t\t\t\t<span class=\"acronym\">Belgian Marine Mammals</span>
\t\t\t\t<p class=\"description\">OD Nature Belgian Marine Data Center</p>
\t\t\t</div>
\t\t</header>

\t\t<div class=\"main-content\">
\t\t";
        // line 117
        $this->displayBlock('main_content', $context, $blocks);
        // line 118
        echo "\t\t</div>
</div>
\t\t<footer>
\t\t\t";
        // line 121
        $this->displayBlock('footer', $context, $blocks);
        // line 191
        echo "\t\t</footer>
\t<a href=\"#\" class=\"scrollup\">Scroll</a> ";
        // line 192
        $this->displayBlock('javascripts', $context, $blocks);
        // line 200
        echo "</body>
</html>



";
    }

    // line 9
    public function block_title($context, array $blocks = array())
    {
    }

    // line 56
    public function block_navigation($context, array $blocks = array())
    {
        // line 57
        echo "\t\t\t\t<div class=\"navbar-header\">
\t\t\t\t\t<button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\"
\t\t\t\t\t\tdata-target=\"#navbar-collapse\">
\t\t\t\t\t\t<span class=\"sr-only\">Toggle navigation</span> <span
\t\t\t\t\t\t\tclass=\"icon-bar\"></span> <span class=\"icon-bar\"></span> <span
\t\t\t\t\t\t\tclass=\"icon-bar\"></span>
\t\t\t\t\t</button>
\t\t\t\t\t<a class=\"navbar-brand\" href=\"/index\">Marine Mammals &#187;</a>
\t\t\t\t</div>

\t\t\t\t<div class=\"collapse navbar-collapse\" id=\"navbar-collapse\">
\t\t\t\t\t<ul class=\"nav navbar-nav\">
\t\t\t\t\t\t<li><a href=\"/about\">About</a></li>
\t\t\t\t\t\t<li><a href=\"/remsem/ecosystem-modelling\">Browse observations</a></li>
\t\t\t\t\t\t<li><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">Management<span
\t\t\t\t\t\t\t\tclass=\"caret\"></span></a>
\t\t\t\t\t\t\t<ul class=\"dropdown-menu\">
\t\t\t\t\t\t\t\t<li class=\"dropdown-header\">Observations</li>
\t\t\t\t\t\t\t\t<li><a href=\"/observations\">Browse</a></li>
\t\t\t\t\t\t\t\t<li><a href=\"/observations/add\">Create
\t\t\t\t\t\t\t\t\t\tnew</a></li>
\t\t\t\t\t\t\t\t<li><a href=\"/remsem/software-and-data/total-suspended-matter\">Update
\t\t\t\t\t\t\t\t\t\texisting</a></li>
\t\t\t\t\t\t\t\t<li><a href=\"/remsem/software-and-data/total-suspended-matter\">Batch
\t\t\t\t\t\t\t\t\t\timport</a></li>
\t\t\t\t\t\t\t\t<li class=\"divider\"></li>
\t\t\t\t\t\t\t\t<li class=\"dropdown-header\">Necropsies</li>
\t\t\t\t\t\t\t\t<li><a href=\"/remsem/software-and-data/turbid-water-software\">Browse</a></li>
\t\t\t\t\t\t\t\t<li><a href=\"/remsem/software-and-data/similarity-spectrum\">Create
\t\t\t\t\t\t\t\t\t\tnew</a></li>
\t\t\t\t\t\t\t\t<li><a href=\"/remsem/software-and-data/total-suspended-matter\">Update
\t\t\t\t\t\t\t\t\t\texisting</a></li>
\t\t\t\t\t\t\t\t<li class=\"divider\"></li>
\t\t\t\t\t\t\t\t<li class=\"dropdown-header\">Manage lists</li>
\t\t\t\t\t\t\t\t<li><a href=\"/taxa/add\">Species</a></li>
\t\t\t\t\t\t\t\t<li><a href=\"/stations/add\">Stations</a></li>
\t\t\t\t\t\t\t\t<li><a href=\"/platforms/add\">Platforms</a></li>
\t\t\t\t\t\t\t\t<li><a href=\"/persons/add\">Persons</a></li>
\t\t\t\t\t\t\t\t<li><a href=\"/sources/add\">Sources</a></li>
\t\t\t\t\t\t\t</ul></li>
\t\t\t\t\t\t<li><a href=\"/remsem/contact\">Contact</a></li>
\t\t\t\t\t</ul>
\t\t\t\t</div>
\t\t\t\t";
    }

    // line 117
    public function block_main_content($context, array $blocks = array())
    {
    }

    // line 121
    public function block_footer($context, array $blocks = array())
    {
        // line 122
        echo "\t\t\t<div class=\"container\">

\t\t\t\t<div class=\"row\">
\t\t\t\t\t<div class=\"col-md-6\">
\t\t\t\t\t\t<strong>Marine Mammals &mdash; <span>OD Nature Belgian Marine Data
\t\t\t\t\t\t\t\tCenter</span></strong><br /> <span class=\"titles\">Contributor(s):
\t\t\t\t\t\t</span> <br /> <a href=\"mailto:j.haelters@mumm.ac.be\">j.haelters@mumm.ac.be</a>
\t\t\t\t\t\t<br /> <a href=\"mailto:t.jauniaux@ulg.ac.be\">t.jauniaux@ulg.ac.be</a>
\t\t\t\t\t\t<br /> <span class=\"titles\">Designed and developed by: </span><br />
\t\t\t\t\t\t<a href=\"http://www.odnature.be/bmdc\">BMDC</a><br />
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"col-md-2\">
\t\t\t\t\t\t<span class=\"titles\">Social media: </span><br> <span
\t\t\t\t\t\t\tclass=\"subtitles\">Follow <strong>RBINS</strong> on:
\t\t\t\t\t\t</span><br> <a
\t\t\t\t\t\t\thref=\"http://www.facebook.com/pages/Museum-voor-Natuurwetenschappen-Mus%C3%A9um-des-Sciences-naturelles/62974540902\"><i
\t\t\t\t\t\t\tclass=\"fa fa-facebook fa-lg\"></i></a> <a
\t\t\t\t\t\t\thref=\"http://twitter.com/RBINSmuseum\"><i
\t\t\t\t\t\t\tclass=\"fa fa-twitter fa-lg\"></i></a> <a
\t\t\t\t\t\t\thref=\"http://plus.google.com/106005649553321310507\"><i
\t\t\t\t\t\t\tclass=\"fa fa-google-plus fa-lg\"></i></a> <a
\t\t\t\t\t\t\thref=\"http://pinterest.com/source/natuurwetenschappen.be\"><i
\t\t\t\t\t\t\tclass=\"fa fa-pinterest fa-lg\"></i></a> <a
\t\t\t\t\t\t\thref=\"http://www.youtube.com/user/Naturalsciences\"><i
\t\t\t\t\t\t\tclass=\"fa fa-youtube fa-lg\"></i></a><br>

\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"col-md-4\">
\t\t\t\t\t\t<p>
\t\t\t\t\t\t\t<span class=\"titles\">Research within our Institute: </span><br> <span
\t\t\t\t\t\t\t\tclass=\"subtitles\">Scientific research: </span><br> <span
\t\t\t\t\t\t\t\tclass=\"sublinks\"><a
\t\t\t\t\t\t\t\thref='http://www.naturalsciences.be/en/science/directional--operations'>Research</a>,
\t\t\t\t\t\t\t\t<a href='http://www.naturalsciences.be/en/science/collections'>Collections</a>,
\t\t\t\t\t\t\t\t<a
\t\t\t\t\t\t\t\thref='http://www.naturalsciences.be/en/science/scientific-support'>Scientific
\t\t\t\t\t\t\t\t\texpertise</a>, <a
\t\t\t\t\t\t\t\thref='http://www.naturalsciences.be/en/science/publications-home'>Publications</a>,
\t\t\t\t\t\t\t\t<a
\t\t\t\t\t\t\t\thref='http://www.naturalsciences.be/en/science/museum-library'>Library</a></span><br>
\t\t\t\t\t\t\t<span class=\"subtitles\">Operational Directorates: </span><br> <span
\t\t\t\t\t\t\t\tclass=\"sublinks\"><a
\t\t\t\t\t\t\t\thref='http://www.naturalsciences.be/en/science/do/98'>Natural
\t\t\t\t\t\t\t\t\tEnvironment</a>, <a
\t\t\t\t\t\t\t\thref='http://www.naturalsciences.be/en/science/do/94'>Earth
\t\t\t\t\t\t\t\t\t&amp; History of Life</a>, <a
\t\t\t\t\t\t\t\thref='http://www.naturalsciences.be/en/science/do/97'>Taxonomy
\t\t\t\t\t\t\t\t\t&amp; Philogeny</a></span><br>
\t\t\t\t\t\t</p>
\t\t\t\t\t\t<p>
\t\t\t\t\t\t\t<span class=\"titles\">You are now visiting: </span><br> <span
\t\t\t\t\t\t\t\tclass=\"sublinks\"> <a
\t\t\t\t\t\t\t\thref=\"http://www.naturalsciences.be/en/science/do/98\">OD Nature</a>
\t\t\t\t\t\t\t\t&#187; <a href=\"http://www.odnature.be/\">Scientific web sites
\t\t\t\t\t\t\t\t\tand applications</a> &#187; <a
\t\t\t\t\t\t\t\thref=\"http://www.odnature.be/remsem/\">REMSEM</a>
\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t</p>
\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t\t<div class=\"row copyright-row\">
\t\t\t\t\t<div class=\"col-md-12\">
\t\t\t\t\t\t&copy; <a href=\"http://www.naturalsciences.be/\">RBINS</a> 2014
\t\t\t\t\t\t&#187; Operational Directorate Natural Environment
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>
\t\t\t";
    }

    // line 192
    public function block_javascripts($context, array $blocks = array())
    {
        // line 193
        echo "\t<script type=\"text/javascript\"
\t\tsrc=\"http://www.odnature.be/js/jquery/jquery-ui-1.10.4.custom/js/jquery-1.10.2.js\"></script>
\t<script type=\"text/javascript\"
\t\tsrc=\"http://www.odnature.be/bootstrap/dist/js/bootstrap.min.js\"></script>
\t<script type=\"text/javascript\"
\t\tsrc=\"http://www.odnature.be/js/odnature/global.js\"></script>
\t";
    }

    public function getTemplateName()
    {
        return "::base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  299 => 193,  296 => 192,  224 => 122,  221 => 121,  216 => 117,  169 => 57,  166 => 56,  161 => 9,  152 => 200,  150 => 192,  147 => 191,  145 => 121,  140 => 118,  138 => 117,  122 => 104,  117 => 101,  115 => 56,  80 => 23,  48 => 21,  44 => 16,  34 => 9,  24 => 1,);
    }
}
