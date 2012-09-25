<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl;

use Zend\Mvc\Controller\AbstractController;
use Zend\ServiceManager\AbstractPluginManager as PluginManager;
use Zend\View\Model\ViewModel;

/**
 * @category   DkplusControllerDsl
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class Dsl implements DslInterface
{
    /** @var PluginManager */
    private $plugins;

    /** @var Executor\ExecutorInterface */
    private $executor;

    /** @var AbstractController */
    private $controller;

    public function __construct(
        PluginManager $plugins,
        Executor\ExecutorInterface $executor,
        AbstractController $controller
    ) {
        $this->plugins    = $plugins;
        $this->executor   = $executor;
        $this->controller = $controller;
    }

    /** @return PluginManager */
    public function getPluginManager()
    {
        return $this->plugins;
    }

    /** @return ExecutorInterface */
    public function getExecutor()
    {
        return $this->executor;
    }

    /** @return \Zend\Stdlib\ResponseInterface|\Zend\View\Model\ModelInterface */
    public function execute(ContainerInterface $container = null)
    {
        if ($container == null) {
            $container = new Container($this->controller, new ViewModel());
        }
        return $this->executor->execute($container);
    }

    public function __call($method, $arguments)
    {
        $phrase = $this->plugins->get($method, $arguments);
        $this->executor->addPhrase($phrase);
        return $this;
    }
}

