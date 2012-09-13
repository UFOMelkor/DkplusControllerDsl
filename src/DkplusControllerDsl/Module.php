<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Module
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerPluginProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Module
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ControllerPluginProviderInterface,
    ServiceProviderInterface
{

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/../../autoload_classmap.php',
            )
        );
    }

    public function getConfig()
    {
        return array();
    }

    public function getControllerPluginConfig()
    {
        return include __DIR__ . '/../../config/controller_plugin.config.php';
    }

    public function getServiceConfig()
    {
        return array();
    }
}

