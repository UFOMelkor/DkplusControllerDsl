<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Module
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl;

use PHPUnit_Framework_TestCase as TestCase;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Module
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class ModuleTest extends TestCase
{
    /** @var Module */
    private $module;

    protected function setUp()
    {
        $this->module = new Module();
    }

    /**
     * @test
     * @group Module/DkplusControllerDsl
     * @group Component/Module
     */
    public function implementsConfigProviderInterface()
    {
        $this->assertInstanceOf('Zend\ModuleManager\Feature\ConfigProviderInterface', $this->module);
    }

    /**
     * @test
     * @group Module/DkplusControllerDsl
     * @group Component/Module
     * @depends implementsConfigProviderInterface
     */
    public function providesConfigAsArray()
    {
        $this->assertInternalType('array', $this->module->getConfig());
    }

    /**
     * @test
     * @group Module/DkplusControllerDsl
     * @group Component/Module
     */
    public function implementsServiceProviderInterface()
    {
        $this->assertInstanceOf('Zend\ModuleManager\Feature\ServiceProviderInterface', $this->module);
    }

    /**
     * @test
     * @group Module/DkplusControllerDsl
     * @group Component/Module
     * @depends implementsServiceProviderInterface
     */
    public function providesServiceConfigAsArray()
    {
        $this->assertInternalType('array', $this->module->getServiceConfig());
    }

    /**
     * @test
     * @group Module/DkplusControllerDsl
     * @group Component/Module
     */
    public function implementsControllerPluginProviderInterface()
    {
        $this->assertInstanceOf('Zend\ModuleManager\Feature\ControllerPluginProviderInterface', $this->module);
    }

    /**
     * @test
     * @group Module/DkplusControllerDsl
     * @group Component/Module
     * @depends implementsControllerPluginProviderInterface
     */
    public function providesControllerPluginConfigAsArray()
    {
        $this->assertInternalType('array', $this->module->getControllerPluginConfig());
    }

    /**
     * @test
     * @group Module/DkplusControllerDsl
     * @group Component/Module
     */
    public function implementsAutoloaderProviderInterface()
    {
        $this->assertInstanceOf('Zend\ModuleManager\Feature\AutoloaderProviderInterface', $this->module);
    }

    /**
     * @test
     * @group Module/DkplusControllerDsl
     * @group Component/Module
     * @depends implementsAutoloaderProviderInterface
     */
    public function providesAutoloaderConfigAsArray()
    {
        $this->assertInternalType('array', $this->module->getAutoloaderConfig());
    }
}

