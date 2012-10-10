<?php
/**
 * @category   Dkplus
 * @package    Base
 * @subpackage IntegrationTest
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusBase;

use PHPUnit_Framework_TestCase as TestCase;
use Zend\Mvc\Application;

/**
 * @category   Dkplus
 * @package    Base
 * @subpackage IntegrationTest
 * @author     Oskar Bley <oskar@programming-php.net>
 * @coversNothing
 */
class ConfigurationTest extends TestCase
{
    /** @var \Zend\Mvc\Controller\PluginManager */
    private static $pluginManager;

    /** @var \Zend\Mvc\Controller\AbstractActionController */
    private $controller;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        $application = Application::init(
            array(
                'modules' => array('DkplusControllerDsl'),
                'module_listener_options' => array(
                    'module_paths' => array(__DIR__ . '../../')
                )
            )
        );
        self::$pluginManager = $application->getServiceManager()->get('ControllerPluginManager');
    }

    protected function setUp()
    {
        parent::setUp();

        $this->controller = $this->getMockForAbstractClass('Zend\Mvc\Controller\AbstractActionController');
        $this->controller->setPluginManager(self::$pluginManager);
    }

    /**
     * @test
     * @group integration
     */
    public function canLoadTheDsl()
    {
        $this->assertInstanceOf('\DkplusControllerDsl\Dsl\DslInterface', $this->controller->dsl());
    }

    /**
     * @test
     * @group integration
     * @dataProvider provideDslPhrases
     */
    public function canLoadTheDslPhrases($phrase)
    {
        $dsl = $this->controller->dsl();

        // we must at a modifiable phrase before
        $dsl->validate();

        // we must use at least one arguments for phrases that needs an array as parameter
        $this->assertInstanceOf('\DkplusControllerDsl\Dsl\DslInterface', $dsl->$phrase('foo'));
    }

    public static function provideDslPhrases()
    {
        return array(
            array('against'),
            array('and'),
            array('asJson'),
            array('as'),
            array('data'),
            array('assign'),
            array('disableLayout'),
            array('error'),
            array('fill'),
            array('form'),
            array('formData'),
            array('formMessages'),
            array('info'),
            array('into'),
            array('message'),
            array('onAjax'),
            array('onAjaxRequest'),
            array('onSuccess'),
            array('onFailure'),
            array('redirect'),
            array('route'),
            array('store'),
            array('success'),
            array('to'),
            array('url'),
            array('use'),
            array('validate'),
            array('warning'),
            array('with')
        );
    }
}
