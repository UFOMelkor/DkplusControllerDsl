<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl\Phrase;

use DkplusControllerDsl\Dsl\ContainerInterface as Container;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class ReplaceContent implements ModifiablePhraseInterface
{
    /** @var string */
    private $controller;

    /** @var array */
    private $routeParameters;

    /** @var string */
    private $route;

    public function setOptions(array $options)
    {
        if (isset($options['controller'])) {
            $this->controller = $options['controller'];
        }
        if (isset($options['route_params'])) {
            $this->routeParameters = $options['route_params'];
        }
        if (isset($options['route'])) {
            $this->route = $options['route'];
        }
    }

    public function execute(Container $container)
    {
        $routeMatch = $container->getController()->getEvent()->getRouteMatch();
        $routeMatchClass = \get_class($routeMatch);
        $routeParameters = array(array('controller' => $this->controller), $this->routeParameters);

        $mergeRouteMatch = new $routeMatchClass($routeParameters);
        $mergeRouteMatch->setMatchedRouteName($this->route ? $this->route : $routeMatch->getMatchedRouteName());

        $routeMatch->merge($mergeRouteMatch);

        $oldStatusCode = $container->getResponse()->getStatusCode();
        $container->getResponse()->setStatusCode(200);


        $model = $container->getController()->forward()->dispatch($this->controller, $this->routeParameters);
        /* @var $model \Zend\View\Model\ModelInterface */
        $container->setViewModel($model);


        $container->getResponse()->setStatusCode($oldStatusCode);
    }
}
