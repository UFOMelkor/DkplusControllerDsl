<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl;

use Zend\ServiceManager\AbstractPluginManager as PluginManager;

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

    /** @var ExecutorInterface */
    private $executor;

    public function __construct(PluginManager $plugins, ExecutorInterface $executor)
    {
        $this->plugins  = $plugins;
        $this->executor = $executor;
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
    public function execute(ContainerInterface $container)
    {
        return $this->executor->execute($container);
    }

    public function __call($method, $arguments)
    {
        $phrase = $this->plugins->get($method, $arguments);
        $this->executor->addPhrase($phrase);
        return $this;
    }
}

