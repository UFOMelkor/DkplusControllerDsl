<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl\Phrase;

use DkplusControllerDsl\Dsl\ContainerInterface as Container;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class ReplaceContent implements ModifiablePhraseInterface, ServiceLocatorAwareInterface
{
    /** @var string */
    private $controller;

    /** @var array */
    private $routeParameters;

    /** @var ServiceLocator */
    private $serviceLocator;

    public function setOptions(array $options)
    {
        if (isset($options['controller'])) {
            $this->controller = $options['controller'];
        }
        if (isset($options['route_params'])) {
            $this->routeParameters = $options['route_params'];
        }
    }

    public function execute(Container $container)
    {
        $content = $container->getController()->forward()->dispatch($this->controller, $this->routeParameters);
        $container->setViewVariable('content', $content);
        $container->getViewModel()->setTemplate('dsl/replace-content');

        if ($this->getServiceLocator()) {
            $viewManager  = $this->getServiceLocator()->get('ViewManager');
            $route404Strategy = $viewManager->getRouteNotFoundStrategy();
            /* @var $route404Strategy \Zend\Mvc\View\Http\RouteNotFoundStrategy */
            $route404Strategy->setNotFoundTemplate('dsl/replace-content');
        }
    }

    /** @return ServiceLocator */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    public function setServiceLocator(ServiceLocator $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }
}
