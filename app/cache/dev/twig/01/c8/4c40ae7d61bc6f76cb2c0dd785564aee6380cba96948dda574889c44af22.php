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
    <meta http-equiv=\"Content-Type\" content=\"text/html\" charset=utf-8
    \" />
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <meta name=\"description\" content=\"Marine Mammals\">
    <meta name=\"author\" content=\"Thomas Vandenberghe\">
    <title>";
        // line 10
        $this->displayBlock('title', $context, $blocks);
        echo "Marine Mammals</title>
    <link rel=\"shortcut icon\"
          href=\"http://www.odnature.be/assets/nav/logos/logo32x32.ico\"/>
    <!--[if lt IE 9]>
    <script src=\"https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js\"></script>
    <script src=\"https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js\"></script>
    <![endif]-->
    ";
        // line 17
        if (isset($context['assetic']['debug']) && $context['assetic']['debug']) {
            // asset "24fb7a2_0"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_24fb7a2_0") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/24fb7a2_css?family=PT+Sans:400,400italic,700,700italic|Patua+One|Yanone+Kaffeesatz_1.css");
            // line 22
            echo "    <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\"/>
    ";
            // asset "24fb7a2_1"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_24fb7a2_1") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/24fb7a2_font-awesome_2.css");
            echo "    <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\"/>
    ";
            // asset "24fb7a2_2"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_24fb7a2_2") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/24fb7a2_odnature_3.css");
            echo "    <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\"/>
    ";
            // asset "24fb7a2_3"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_24fb7a2_3") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/24fb7a2_mm_4.css");
            echo "    <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\"/>
    ";
        } else {
            // asset "24fb7a2"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_24fb7a2") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/24fb7a2.css");
            echo "    <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\"/>
    ";
        }
        unset($context["asset_url"]);
        // line 24
        echo "
</head>
<body>
<div class=\"container\">
    <header>
        <div class=\"top-links\">
            <a href=\"http://www.naturalsciences.be/\">museum</a><span class=\"sep\">&#187;</span>
            <a href=\"http://www.naturalsciences.be/en/science/home\">science</a><span
                    class=\"sep\">&#187;</span> <a
                    href=\"http://www.naturalsciences.be/en/science/do/98\">od nature</a><span
                    class=\"sep\">&#187;</span> <a href=\"http://www.odnature.be/\">scientific
                web sites and applications</a>
        </div>
        <div class=\"top-links\">
            <form class=\"form-inline top-search\" role=\"form\">
                <div class=\"form-group\"></div>
            </form>
        </div>
        <div class=\"branding-main\">
            <div class=\"branding-logo\">
                <img src=\"http://www.odnature.be/assets/nav/logos/museum.png\" alt=\"logo\"/>
            </div>
            <div class=\"branding-text\">
\t\t\t\t\t<span class=\"institution\">Royal Belgian Institute of Natural
\t\t\t\t\t\tSciences</span>

                <p class=\"directorate\">
                    Operational Directorate Natural Environment<br/> <span
                            class=\"swap-branding\">scientific web sites and applications</span>
                </p>
            </div>
        </div>
        <div class=\"navmenu\">
            <nav class=\"navbar navbar-default\" role=\"navigation\">
                ";
        // line 58
        $this->displayBlock('navigation', $context, $blocks);
        // line 103
        echo "            </nav>
        </div>
        <div class=\"showcase hidden-print\">
            <img src=\"";
        // line 106
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("img/seals.jpg"), "html", null, true);
        echo "\" alt=\"photo banner\"/>

            <div class=\"tagline\">
                <span class=\"acronym\">Belgian Marine Mammals</span>

                <p class=\"description\">OD Nature Belgian Marine Data Center</p>
            </div>
        </div>
        <div class=\"showcase-mobile\">
            <span class=\"acronym\">Belgian Marine Mammals</span>

            <p class=\"description\">OD Nature Belgian Marine Data Center</p>
        </div>
    </header>

    <div class=\"main-content\">
        ";
        // line 122
        $this->displayBlock('main_content', $context, $blocks);
        // line 123
        echo "    </div>
</div>
<footer>
    ";
        // line 126
        $this->displayBlock('footer', $context, $blocks);
        // line 197
        echo "</footer>
<a href=\"#\" class=\"scrollup\">Scroll</a> ";
        // line 198
        $this->displayBlock('javascripts', $context, $blocks);
        // line 206
        echo "</body>
</html>



";
    }

    // line 10
    public function block_title($context, array $blocks = array())
    {
    }

    // line 58
    public function block_navigation($context, array $blocks = array())
    {
        // line 59
        echo "                    <div class=\"navbar-header\">
                        <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\"
                                data-target=\"#navbar-collapse\">
                            <span class=\"sr-only\">Toggle navigation</span> <span
                                    class=\"icon-bar\"></span> <span class=\"icon-bar\"></span> <span
                                    class=\"icon-bar\"></span>
                        </button>
                        <a class=\"navbar-brand\" href=\"/index\">Marine Mammals &#187;</a>
                    </div>

                    <div class=\"collapse navbar-collapse\" id=\"navbar-collapse\">
                        <ul class=\"nav navbar-nav\">
                            <li><a href=\"/about\">About</a></li>
                            <li><a href=\"/observations\">Browse observations</a></li>
                            <li><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">Management<span
                                            class=\"caret\"></span></a>
                                <ul class=\"dropdown-menu\">
                                    <li class=\"dropdown-header\">Observations</li>
                                    <li><a href=\"/observations\">Browse</a></li>
                                    <li><a href=\"/observations/add\">Create
                                            new</a></li>
                                    <li><a href=\"/observations/update/4006\">Update
                                            existing</a></li>
                                    <li><a href=\"/observations/import\">Batch
                                            import</a></li>
                                    <li class=\"divider\"></li>
                                    <li class=\"dropdown-header\">Necropsies</li>
                                    <li><a href=\"/necropsies\">Browse</a></li>
                                    <li><a href=\"/necropsies/add\">Create
                                            new</a></li>
                                    <li><a href=\"/necropsies/update/201\">Update
                                            existing</a></li>
                                    <li class=\"divider\"></li>
                                    <li class=\"dropdown-header\">Manage lists</li>
                                    <li><a href=\"/taxa/add\">Species</a></li>
                                    <li><a href=\"/stations/add\">Stations</a></li>
                                    <li><a href=\"/platforms/add\">Platforms</a></li>
                                    <li><a href=\"/persons/add\">Persons</a></li>
                                    <li><a href=\"/sources/add\">Sources</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                ";
    }

    // line 122
    public function block_main_content($context, array $blocks = array())
    {
    }

    // line 126
    public function block_footer($context, array $blocks = array())
    {
        // line 127
        echo "        <div class=\"container\">

            <div class=\"row\">
                <div class=\"col-md-6\">
                    <strong>Marine Mammals &mdash; <span>OD Nature Belgian Marine Data
\t\t\t\t\t\t\t\tCenter</span></strong><br/> <span class=\"titles\">Contributor(s):
\t\t\t\t\t\t</span> <br/> <a href=\"mailto:j.haelters@mumm.ac.be\">j.haelters@mumm.ac.be</a>
                    <br/> <a href=\"mailto:t.jauniaux@ulg.ac.be\">t.jauniaux@ulg.ac.be</a>
                    <br/> <span class=\"titles\">Designed and developed by: </span><br/>
                    <a href=\"http://www.odnature.be/bmdc\">BMDC</a><br/>
                </div>
                <div class=\"col-md-2\">
                    <span class=\"titles\">Social media: </span><br> <span
                            class=\"subtitles\">Follow <strong>RBINS</strong> on:
\t\t\t\t\t\t</span><br> <a
                            href=\"http://www.facebook.com/pages/Museum-voor-Natuurwetenschappen-Mus%C3%A9um-des-Sciences-naturelles/62974540902\"><i
                                class=\"fa fa-facebook fa-lg\"></i></a> <a
                            href=\"http://twitter.com/RBINSmuseum\"><i
                                class=\"fa fa-twitter fa-lg\"></i></a> <a
                            href=\"http://plus.google.com/106005649553321310507\"><i
                                class=\"fa fa-google-plus fa-lg\"></i></a> <a
                            href=\"http://pinterest.com/source/natuurwetenschappen.be\"><i
                                class=\"fa fa-pinterest fa-lg\"></i></a> <a
                            href=\"http://www.youtube.com/user/Naturalsciences\"><i
                                class=\"fa fa-youtube fa-lg\"></i></a><br>

                </div>
                <div class=\"col-md-4\">
                    <p>
                        <span class=\"titles\">Research within our Institute: </span><br> <span
                                class=\"subtitles\">Scientific research: </span><br> <span
                                class=\"sublinks\"><a
                                    href='http://www.naturalsciences.be/en/science/directional--operations'>Research</a>,
\t\t\t\t\t\t\t\t<a href='http://www.naturalsciences.be/en/science/collections'>Collections</a>,
\t\t\t\t\t\t\t\t<a
                                        href='http://www.naturalsciences.be/en/science/scientific-support'>Scientific
                                    expertise</a>, <a
                                    href='http://www.naturalsciences.be/en/science/publications-home'>Publications</a>,
\t\t\t\t\t\t\t\t<a
                                        href='http://www.naturalsciences.be/en/science/museum-library'>Library</a></span><br>
                        <span class=\"subtitles\">Operational Directorates: </span><br> <span
                                class=\"sublinks\"><a
                                    href='http://www.naturalsciences.be/en/science/do/98'>Natural
                                Environment</a>, <a
                                    href='http://www.naturalsciences.be/en/science/do/94'>Earth
                                &amp; History of Life</a>, <a
                                    href='http://www.naturalsciences.be/en/science/do/97'>Taxonomy
                                &amp; Philogeny</a></span><br>
                    </p>

                  <!--  <p>
                        <span class=\"titles\">You are now visiting: </span><br> <span
                                class=\"sublinks\"> <a
                                    href=\"http://www.naturalsciences.be/en/science/do/98\">OD Nature</a>
\t\t\t\t\t\t\t\t&#187; <a href=\"http://www.odnature.be/\">Scientific web sites
                                and applications</a> &#187; <a
                                    href=\"http://www.odnature.be/remsem/\">REMSEM</a>
\t\t\t\t\t\t\t</span>
                    </p>-->
                </div>
            </div>

            <div class=\"row copyright-row\">
                <div class=\"col-md-12\">
                    &copy; <a href=\"http://www.naturalsciences.be/\">RBINS</a> 2014
                    &#187; Operational Directorate Natural Environment
                </div>
            </div>
        </div>
    ";
    }

    // line 198
    public function block_javascripts($context, array $blocks = array())
    {
        // line 199
        echo "    <script type=\"application/javascript\" src=\"http://code.jquery.com/jquery-1.11.2.min.js\"></script>
    <script type=\"application/javascript\" src=\"http://code.jquery.com/ui/1.11.2/jquery-ui.js\"></script>
    <script type=\"application/javascript\"
            src=\"http://www.odnature.be/bootstrap/dist/js/bootstrap.min.js\"></script>
    <script type=\"application/javascript\"
            src=\"http://www.odnature.be/js/odnature/global.js\"></script>
";
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
        return array (  305 => 199,  302 => 198,  229 => 127,  226 => 126,  221 => 122,  174 => 59,  171 => 58,  166 => 10,  157 => 206,  155 => 198,  152 => 197,  150 => 126,  145 => 123,  143 => 122,  124 => 106,  119 => 103,  117 => 58,  81 => 24,  49 => 22,  45 => 17,  35 => 10,  24 => 1,);
    }
}
