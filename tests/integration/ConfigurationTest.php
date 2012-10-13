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
    public function canLoadTheDslPhrases($phrase, array $params)
    {
        $dsl = $this->controller->dsl();

        // we must at a modifiable phrase before
        $dsl->validate();

        $this->assertInstanceOf(
            '\DkplusControllerDsl\Dsl\DslInterface',
            \call_user_func_array(array($dsl, $phrase), $params)
        );
    }

    public static function provideDslPhrases()
    {
        return array(
            array('add', array()),
            array('against', array(array())),
            array('and', array()),
            array('asJson', array()),
            array('as', array('alias')),
            array('data', array(array())),
            array('assign', array()),
            array('controllerAction', array('UserController', 'index')),
            array('disableLayout', array()),
            array('error', array()),
            array('fill', array()),
            array('form', array()),
            array('formData', array()),
            array('formMessages', array()),
            array('info', array()),
            array('into', array('strtrim')),
            array('message', array('everything ok')),
            array('notFound', array()),
            array('onAjax', array('sub-dsl')),
            array('onAjaxRequest', array('sub-dsl')),
            array('onSuccess', array('sub-dsl')),
            array('onFailure', array('sub-dsl')),
            array('redirect', array()),
            array('replaceContent', array()),
            array('route', array('my/route')),
            array('set', array()),
            array('store', array()),
            array('success', array()),
            array('to', array()),
            array('url', array('http://www.example.org/')),
            array('use', array('variable')),
            array('validate', array()),
            array('warning', array()),
            array('with', array())
        );
    }
}
