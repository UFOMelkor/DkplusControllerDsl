<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Controller\Plugin
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Controller\Plugin;

use DkplusControllerDsl\Dsl\Dsl as DslInstance;
use DkplusControllerDsl\Dsl\Executor\Executor as DslExecutor;
use DkplusControllerDsl\Dsl\Executor\PrePostExecutorDecorator;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\ServiceManager\AbstractPluginManager;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Controller\Plugin
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class Dsl extends AbstractPlugin
{
    /** @var AbstractPluginManager */
    private $pluginManager;

    public function __construct(AbstractPluginManager $pluginManager)
    {
        $this->pluginManager = $pluginManager;
    }

    public function __invoke()
    {
        $executor = new \DkplusControllerDsl\Dsl\Executor\ContainerInjectionExecutor(
            new PrePostExecutorDecorator(
                new DslExecutor()
            )
        );
        return new DslInstance($this->pluginManager, $executor, $this->getController());
    }
}
