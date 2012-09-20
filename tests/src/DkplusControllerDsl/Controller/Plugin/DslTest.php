<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Controller\Plugin
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Controller\Plugin;

use PHPUnit_Framework_TestCase as TestCase;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Controller\Plugin
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class DslTest extends TestCase
{
    /** @var \Zend\ServiceManager\AbstractPluginManager|\PHPUnit_Framework_MockObject_MockObject */
    private $pluginManager;

    /** @var Dsl */
    private $plugin;

    protected function setUp()
    {
        $this->pluginManager = $this->getMockForAbstractClass('Zend\ServiceManager\AbstractPluginManager');
        $this->plugin        = new Dsl($this->pluginManager);

        $controller = $this->getMock('Zend\Mvc\Controller\AbstractController');
        $this->plugin->setController($controller);
    }

    /**
     * @test
     * @group Component/ControllerPlugin
     * @group Module/DkplusControllerDsl
     * @testdox is a plugin
     */
    public function isPlugin()
    {
        $this->assertInstanceOf('Zend\Mvc\Controller\Plugin\PluginInterface', $this->plugin);
    }

    /**
     * @test
     * @group Component/ControllerPlugin
     * @group Module/DkplusControllerDsl
     */
    public function createsDslInstances()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\DslInterface', $this->plugin->__invoke());
    }

    /**
     * @test
     * @group Component/ControllerPlugin
     * @group Module/DkplusControllerDsl
     */
    public function createsStandardDslInstances()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Dsl', $this->plugin->__invoke());
    }

    /**
     * @test
     * @group Component/ControllerPlugin
     * @group Module/DkplusControllerDsl
     */
    public function injectsPrePostExecutorIntoDslInstances()
    {
        $dsl = $this->plugin->__invoke();
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\PrePostExecutorDecorator', $dsl->getExecutor());
    }

    /**
     * @test
     * @group Component/ControllerPlugin
     * @group Module/DkplusControllerDsl
     */
    public function injectsPluginManagerIntoDslInstances()
    {
        $dsl = $this->plugin->__invoke();
        $this->assertInstanceOf('Zend\ServiceManager\AbstractPluginManager', $dsl->getPluginManager());
    }

    /**
     * @test
     * @group Component/ControllerPlugin
     * @group Module/DkplusControllerDsl
     */
    public function createsNewDslInstancesOnEveryCall()
    {
        $firstDsl = $this->plugin->__invoke();
        $this->assertNotSame($firstDsl, $this->plugin->__invoke());
    }
}

