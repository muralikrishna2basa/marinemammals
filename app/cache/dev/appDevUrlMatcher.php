<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appDevUrlMatcher
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appDevUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        if (0 === strpos($pathinfo, '/css/24fb7a2')) {
            // _assetic_24fb7a2
            if ($pathinfo === '/css/24fb7a2.css') {
                return array (  '_controller' => 'assetic.controller:render',  'name' => '24fb7a2',  'pos' => NULL,  '_format' => 'css',  '_route' => '_assetic_24fb7a2',);
            }

            if (0 === strpos($pathinfo, '/css/24fb7a2_')) {
                // _assetic_24fb7a2_0
                if ($pathinfo === '/css/24fb7a2_css?family=PT+Sans:400,400italic,700,700italic|Patua+One|Yanone+Kaffeesatz_1.css') {
                    return array (  '_controller' => 'assetic.controller:render',  'name' => '24fb7a2',  'pos' => 0,  '_format' => 'css',  '_route' => '_assetic_24fb7a2_0',);
                }

                // _assetic_24fb7a2_1
                if ($pathinfo === '/css/24fb7a2_font-awesome_2.css') {
                    return array (  '_controller' => 'assetic.controller:render',  'name' => '24fb7a2',  'pos' => 1,  '_format' => 'css',  '_route' => '_assetic_24fb7a2_1',);
                }

                // _assetic_24fb7a2_2
                if ($pathinfo === '/css/24fb7a2_odnature_3.css') {
                    return array (  '_controller' => 'assetic.controller:render',  'name' => '24fb7a2',  'pos' => 2,  '_format' => 'css',  '_route' => '_assetic_24fb7a2_2',);
                }

                // _assetic_24fb7a2_3
                if ($pathinfo === '/css/24fb7a2_mm_4.css') {
                    return array (  '_controller' => 'assetic.controller:render',  'name' => '24fb7a2',  'pos' => 3,  '_format' => 'css',  '_route' => '_assetic_24fb7a2_3',);
                }

            }

        }

        if (0 === strpos($pathinfo, '/_')) {
            // _wdt
            if (0 === strpos($pathinfo, '/_wdt') && preg_match('#^/_wdt/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_wdt')), array (  '_controller' => 'web_profiler.controller.profiler:toolbarAction',));
            }

            if (0 === strpos($pathinfo, '/_profiler')) {
                // _profiler_home
                if (rtrim($pathinfo, '/') === '/_profiler') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_profiler_home');
                    }

                    return array (  '_controller' => 'web_profiler.controller.profiler:homeAction',  '_route' => '_profiler_home',);
                }

                if (0 === strpos($pathinfo, '/_profiler/search')) {
                    // _profiler_search
                    if ($pathinfo === '/_profiler/search') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchAction',  '_route' => '_profiler_search',);
                    }

                    // _profiler_search_bar
                    if ($pathinfo === '/_profiler/search_bar') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchBarAction',  '_route' => '_profiler_search_bar',);
                    }

                }

                // _profiler_purge
                if ($pathinfo === '/_profiler/purge') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:purgeAction',  '_route' => '_profiler_purge',);
                }

                // _profiler_info
                if (0 === strpos($pathinfo, '/_profiler/info') && preg_match('#^/_profiler/info/(?P<about>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_info')), array (  '_controller' => 'web_profiler.controller.profiler:infoAction',));
                }

                // _profiler_phpinfo
                if ($pathinfo === '/_profiler/phpinfo') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  '_route' => '_profiler_phpinfo',);
                }

                // _profiler_search_results
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/search/results$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_search_results')), array (  '_controller' => 'web_profiler.controller.profiler:searchResultsAction',));
                }

                // _profiler
                if (preg_match('#^/_profiler/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler')), array (  '_controller' => 'web_profiler.controller.profiler:panelAction',));
                }

                // _profiler_router
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/router$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_router')), array (  '_controller' => 'web_profiler.controller.router:panelAction',));
                }

                // _profiler_exception
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception')), array (  '_controller' => 'web_profiler.controller.exception:showAction',));
                }

                // _profiler_exception_css
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception\\.css$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception_css')), array (  '_controller' => 'web_profiler.controller.exception:cssAction',));
                }

            }

            if (0 === strpos($pathinfo, '/_configurator')) {
                // _configurator_home
                if (rtrim($pathinfo, '/') === '/_configurator') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_configurator_home');
                    }

                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::checkAction',  '_route' => '_configurator_home',);
                }

                // _configurator_step
                if (0 === strpos($pathinfo, '/_configurator/step') && preg_match('#^/_configurator/step/(?P<index>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_configurator_step')), array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::stepAction',));
                }

                // _configurator_final
                if ($pathinfo === '/_configurator/final') {
                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::finalAction',  '_route' => '_configurator_final',);
                }

            }

            // _twig_error_test
            if (0 === strpos($pathinfo, '/_error') && preg_match('#^/_error/(?P<code>\\d+)(?:\\.(?P<_format>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_twig_error_test')), array (  '_controller' => 'twig.controller.preview_error:previewErrorPageAction',  '_format' => 'html',));
            }

        }

        // taxa_homepage
        if (0 === strpos($pathinfo, '/hello') && preg_match('#^/hello/(?P<name>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'taxa_homepage')), array (  '_controller' => 'TaxaBundle:Default:index',));
        }

        // mm_homepage
        if (rtrim($pathinfo, '/') === '') {
            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'HEAD'));
                goto not_mm_homepage;
            }

            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'mm_homepage');
            }

            return array (  '_controller' => 'AppBundle\\Controller\\PageController::indexAction',  '_route' => 'mm_homepage',);
        }
        not_mm_homepage:

        // mm_about
        if ($pathinfo === '/about') {
            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'HEAD'));
                goto not_mm_about;
            }

            return array (  '_controller' => 'AppBundle\\Controller\\PageController::aboutAction',  '_route' => 'mm_about',);
        }
        not_mm_about:

        // mm_taxa_index
        if ($pathinfo === '/taxa') {
            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'HEAD'));
                goto not_mm_taxa_index;
            }

            return array (  '_controller' => 'TaxaBundle\\Controller\\PageController::indexAction',  '_route' => 'mm_taxa_index',);
        }
        not_mm_taxa_index:

        // mm_observations_index
        if ($pathinfo === '/observations') {
            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'HEAD'));
                goto not_mm_observations_index;
            }

            return array (  '_controller' => 'AppBundle\\Controller\\ObservationsController::indexAction',  '_route' => 'mm_observations_index',);
        }
        not_mm_observations_index:

        if (0 === strpos($pathinfo, '/taxa/add')) {
            // mm_taxa_add_new
            if ($pathinfo === '/taxa/add') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_mm_taxa_add_new;
                }

                return array (  '_controller' => 'TaxaBundle\\Controller\\PageController::newAction',  '_route' => 'mm_taxa_add_new',);
            }
            not_mm_taxa_add_new:

            // mm_taxa_add_create
            if ($pathinfo === '/taxa/add') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_mm_taxa_add_create;
                }

                return array (  '_controller' => 'TaxaBundle\\Controller\\PageController::createAction',  '_route' => 'mm_taxa_add_create',);
            }
            not_mm_taxa_add_create:

        }

        if (0 === strpos($pathinfo, '/persons/add')) {
            // mm_persons_add_new
            if ($pathinfo === '/persons/add') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_mm_persons_add_new;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\PersonsController::newAction',  '_route' => 'mm_persons_add_new',);
            }
            not_mm_persons_add_new:

            // mm_persons_add_create
            if ($pathinfo === '/persons/add') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_mm_persons_add_create;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\PersonsController::createAction',  '_route' => 'mm_persons_add_create',);
            }
            not_mm_persons_add_create:

        }

        if (0 === strpos($pathinfo, '/stations/add')) {
            // mm_stations_add_new
            if ($pathinfo === '/stations/add') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_mm_stations_add_new;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\StationsController::newAction',  '_route' => 'mm_stations_add_new',);
            }
            not_mm_stations_add_new:

            // mm_stations_add_create
            if ($pathinfo === '/stations/add') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_mm_stations_add_create;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\StationsController::createAction',  '_route' => 'mm_stations_add_create',);
            }
            not_mm_stations_add_create:

        }

        if (0 === strpos($pathinfo, '/platforms/add')) {
            // mm_platforms_add_new
            if ($pathinfo === '/platforms/add') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_mm_platforms_add_new;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\PlatformsController::newAction',  '_route' => 'mm_platforms_add_new',);
            }
            not_mm_platforms_add_new:

            // mm_platforms_add_create
            if ($pathinfo === '/platforms/add') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_mm_platforms_add_create;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\PlatformsController::createAction',  '_route' => 'mm_platforms_add_create',);
            }
            not_mm_platforms_add_create:

        }

        if (0 === strpos($pathinfo, '/sources/add')) {
            // mm_sources_add_new
            if ($pathinfo === '/sources/add') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_mm_sources_add_new;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\SourcesController::newAction',  '_route' => 'mm_sources_add_new',);
            }
            not_mm_sources_add_new:

            // mm_sources_add_create
            if ($pathinfo === '/sources/add') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_mm_sources_add_create;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\SourcesController::createAction',  '_route' => 'mm_sources_add_create',);
            }
            not_mm_sources_add_create:

        }

        if (0 === strpos($pathinfo, '/observations/add')) {
            // mm_observations_add_new
            if ($pathinfo === '/observations/add') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_mm_observations_add_new;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\ObservationsController::newAction',  '_route' => 'mm_observations_add_new',);
            }
            not_mm_observations_add_new:

            // mm_observations_add_create
            if ($pathinfo === '/observations/add') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_mm_observations_add_create;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\ObservationsController::createAction',  '_route' => 'mm_observations_add_create',);
            }
            not_mm_observations_add_create:

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
