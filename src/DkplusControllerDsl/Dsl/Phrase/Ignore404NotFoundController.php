<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl\Phrase;

use DkplusControllerDsl\Dsl\ContainerInterface as Container;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class Ignore404NotFoundController implements ServiceLocatorAwareInterface, ExecutablePhraseInterface
{
    /** @var ServiceLocator */
    private $serviceLocator;

    public function execute(Container $container)
    {
        if ($container->getResponse()->getStatusCode() != 404) {
            return;
        }

        $viewModel   = $container->getViewModel();
        $viewManager = $this->getServiceLocator()->getServiceLocator()->get('ViewManager');
        $route404Strategy = $viewManager->getRouteNotFoundStrategy();
        /* @var $route404Strategy \Zend\Mvc\View\Http\RouteNotFoundStrategy */
        $route404Strategy->setNotFoundTemplate($viewModel->getTemplate());
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
