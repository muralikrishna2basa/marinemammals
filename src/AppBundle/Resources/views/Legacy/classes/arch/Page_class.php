<?php

/**
 *    Class Page v1.0.0
 *  Author: De Winter Johan
 *  Last Modified:23/12/2009
 *
 */
class Page
{
    /**
     * Page title
     *
     * @var string
     */
    private $title = "Default Page";

    /**
     * Array of html links
     * array(<link rel="stylesheet" type="text/css" href="tab_output.css" ></link>)
     * @var array
     */
    protected $heads = array();

    /**
     * array of html blocks constructing the body
     *
     * @var array
     */
    protected $bodies = array();


    public function __construct($title = false)
    {
        if (is_string($title) == true) {
            $this->title = $title;
        }
        $this->addHead(array('<link rel="stylesheet" type="text/css" href="/legacy/css/Layout/Page.css" />'));
    }

    /**
     * Method to add html block elements to the header( i.e required scripts(javascript, css))
     *
     * @param array $heads
     */
    public function addHead(array $heads)
    {

        foreach ($heads as $head) {
            if (in_array($head, $this->heads) != true) {
                $this->heads[] = $head;
            }
        }
    }

    /**
     * The class delete the header corresponding to the element specified
     * if nothing is supplied, then it deletes all existing javascript files
     * @param string $elem
     */
    public function cleanHead($elem = '.js')
    {
        foreach ($this->heads as $key => $header) {
            if (substr_count($header, $elem) != 0) {
                unset($this->heads[$key]);
            }
        }

    }

    public function addBody(array $bodies)
    {
        foreach ($bodies as $body) {
            if (is_string($body) == true) {
                $this->bodies[] = $body;
            }
        }
    }

    public function __toString()
    {
        $content = $this->buildContent();

        $wrapper = "<div id='Layout_wrapper'>$content</div>";

        $footer = $this->buildFooter();

        //$this->addBody(array($header,$wrapper,$footer));
        $this->addBody(array($wrapper,$footer));

        $heads = implode('\n', $this->heads);

        $body = implode('\n', $this->bodies);

        header("Content-Security-Policy: script-src 'self' 'unsafe-inline'");

        $page= <<<EOD
    <!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html" charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Marine Mammals">
    <meta name="author" content="Thomas Vandenberghe">
    <title>$this->title</title>
    <link rel="shortcut icon"
          href="http://www.odnature.be/assets/nav/logos/logo32x32.ico"/>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet"
          href="/css/0600193_css%3Ffamily=PT+Sans:400,400italic,700,700italic|Patua+One|Yanone+Kaffeesatz_1.css"/>
    <link rel="stylesheet" href="/css/0600193_font-awesome_2.css"/>
    <link rel="stylesheet" href="/css/0600193_odnature_3.css"/>
    <link rel="stylesheet" href="/css/0600193_mm_4.css"/>


    <link rel="stylesheet" href="/css/e8685cd_datepicker_1.css"/>
    <link rel="stylesheet" href="/css/e8685cd_font-awesome_2.css"/>
    <link rel="stylesheet" href="/css/e8685cd_jquery.qtip.min_3.css"/>
    <link rel="stylesheet" href="/css/e8685cd_select2.min_4.css"/>
    $heads
</head>
<body>
<div class="container">
    <header>
        <div class="top-links">
            <a href="http://www.naturalsciences.be/">museum</a><span class="sep">&#187;</span>
            <a href="http://www.naturalsciences.be/en/science/home">science</a><span
                class="sep">&#187;</span> <a
                href="http://www.naturalsciences.be/en/science/do/98">od nature</a><span
                class="sep">&#187;</span> <a href="http://www.odnature.be/">scientific
            web sites and applications</a>
        </div>
        <div class="top-links">
            <span>Logged in as tvandenberghe</span>
            <a href="/logout" class="navbar-pseudo-btn-link">Logout</a>
        </div>
        <div class="branding-main">
            <div class="branding-logo">
                <img src="http://www.odnature.be/assets/nav/logos/museum.png" alt="logo"/>
            </div>
            <div class="branding-text">
					<span class="institution">Royal Belgian Institute of Natural
						Sciences</span>

                <p class="directorate">
                    Operational Directorate Natural Environment<br/> <span
                        class="swap-branding">scientific web sites and applications</span>
                </p>
            </div>
        </div>
        <div class="branding-main branding-right">
            <div class="branding-logo">
                <img src="/images/logo_ulg.gif" alt="logo"/>
            </div>
            <div class="branding-text">
                <span class="institution">Université de Liège</span>

                <p class="directorate">
                    Faculté de Médecine Vétérinaire<br/>
                </p>
            </div>
        </div>
        <div class="navmenu">
            <nav class="navbar navbar-default" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse"
                            data-target="#navbar-collapse">
                        <span class="sr-only">Toggle navigation</span> <span
                            class="icon-bar"></span> <span class="icon-bar"></span> <span
                            class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">Marine Mammals &#187;</a>
                </div>

                <div class="collapse navbar-collapse" id="navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a class="dropdown-toggle" data-toggle="dropdown" href="#">About<span
                                class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="/observations/about">Strandings and observations</a></li>
                                <li><a href="/necropsies/about">Necropsies</a></li>
                            </ul>
                        </li>
                        <li><a class="dropdown-toggle" data-toggle="dropdown" href="#">Browse data<span
                                class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="/observations">Strandings and observations</a></li>
                                <li><a href="/tissuebank">Tissue bank</a></li>
                            </ul>
                        </li>

                        <li><a class="dropdown-toggle" data-toggle="dropdown" href="#">Management<span
                                class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-header">Observations</li>
                                <li><a href="/mgmt/observations">Browse</a></li>
                                <li><a href="/mgmt/observations/add">Create
                                    new</a></li>
                                <li><a href="/mgmt/observations/import">Batch
                                    import</a></li>
                                <li class="divider"></li>
                                <li class="dropdown-header">Necropsies</li>
                                <li><a href="/mgmt/necropsies">Browse</a></li>
                                <li><a href="/mgmt/necropsies/add-edit">Create
                                    new</a></li>

                                <li class="divider"></li>
                                <li class="dropdown-header">Manage lists</li>
                                <li><a href="/mgmt/taxa/add">Species</a></li>
                                <li><a href="/mgmt/stations/add">Stations</a></li>
                                <li><a href="/mgmt/platforms/add">Platforms</a></li>
                                <li><a href="/mgmt/persons/add">Persons</a></li>
                                <li><a href="/mgmt/sources/add">Sources</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="showcase hidden-print">
            <img src="/images/head.jpg" alt="photo banner"/>

            <div class="tagline">
                <span class="acronym">Belgian Marine Mammals</span>
            </div>
        </div>
        <div class="showcase-mobile">
            <span class="acronym">Belgian Marine Mammals</span>
        </div>
    </header>

    <div class="main-content">
        <div class="col-lg-12">
            $body
        </div>
    </div>
</div>
<footer>
    <div class="container">

        <div class="row">
            <div class="col-md-6">
                <strong>Marine Mammals &mdash;
                    <span>RBINS-OD Nature/ULg-Faculty of Veterinary medicine</span></strong><br/> <span class="titles">Contributor(s):
						</span> <br/> <a href="mailto:j.haelters@naturalsciences.be">j.haelters@naturalsciences.be</a>
                <br/> <a href="mailto:t.jauniaux@ulg.ac.be">t.jauniaux@ulg.ac.be</a>
                <br/> <span class="titles">Designed and developed by: </span><br/>
                <a href="http://www.odnature.be/bmdc">Belgian Marine Data Center</a><br/>
            </div>
            <div class="col-md-2">
                <span class="titles">Social media: </span><br> <span class="subtitles">Follow <strong>RBINS</strong> on:</span><br>
                <a href="http://www.facebook.com/pages/Museum-voor-Natuurwetenschappen-Mus%C3%A9um-des-Sciences-naturelles/62974540902"><i
                        class="fa fa-facebook fa-lg"></i></a>
                <a href="http://twitter.com/RBINSmuseum"><i class="fa fa-twitter fa-lg"></i></a>
                <a href="http://plus.google.com/106005649553321310507"><i class="fa fa-google-plus fa-lg"></i></a>
                <a href="http://pinterest.com/source/natuurwetenschappen.be"><i class="fa fa-pinterest fa-lg"></i></a>
                <a href="http://www.youtube.com/user/Naturalsciences"><i class="fa fa-youtube fa-lg"></i></a><br>
                <span class="subtitles">Follow <strong>ULg</strong> on:</span><br>
                <a href="http://www.facebook.com/universitedeliege"><i class="fa fa-facebook fa-lg"></i></a>
                <a href="http://www.twitter.com/UniversiteLiege"><i class="fa fa-twitter fa-lg"></i></a>
                <a href="http://www.linkedin.com/company/university-of-liege"><i class="fa fa-linkedin fa-lg"></i></a>
            </div>
            <div class="col-md-4">
                <p>
                    <span class="titles">Research at our institutes: </span><br> <span
                        class="subtitles">Scientific research at RBINS: </span><br> <span
                        class="sublinks"><a
                        href='http://www.naturalsciences.be/en/science/directional--operations'>Research</a>,
								<a href='http://www.naturalsciences.be/en/science/collections'>Collections</a>,
								<a
                                        href='http://www.naturalsciences.be/en/science/scientific-support'>Scientific
                                    expertise</a>, <a
                            href='http://www.naturalsciences.be/en/science/publications-home'>Publications</a>,
								<a
                                        href='http://www.naturalsciences.be/en/science/museum-library'>Library</a></span><br>
                    <span class="subtitles">Operational Directorates within RBINS: </span><br> <span
                        class="sublinks"><a
                        href='http://www.naturalsciences.be/en/science/do/98'>Natural
                    Environment</a>, <a
                        href='http://www.naturalsciences.be/en/science/do/94'>Earth
                    &amp; History of Life</a>, <a
                        href='http://www.naturalsciences.be/en/science/do/97'>Taxonomy
                    &amp; Philogeny</a></span><br>
                    <span class="subtitles">Faculty of Veterinary medicine: </span><br> <span
                        class="sublinks"><a
                        href='http://www.fmv.ulg.ac.be'>Faculty page</a>, <a
                        href='http://www.fmv.ulg.ac.be/cms/c_267191/en/department-of-morphology-and-pathology-dmp'>Department
                    of Morphology and Pathology</a></span>

                </p>
            </div>
        </div>

        <div class="row copyright-row">
            <div class="col-md-12">
                &copy; <a href="http://www.naturalsciences.be/">RBINS</a> 2014
                &#187; Operational Directorate Natural Environment
            </div>
        </div>
    </div>
</footer>


<script type="application/javascript" src="/legacy/js/bootstrap-dropdown.js"></script>
<script type="application/javascript">
$('.nav').dropdown();
</script>
</body>
</html>
EOD;

return stripcslashes($page); // escape all backslash caracters ( recognise \n )
    }
}