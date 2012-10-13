<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl\Phrase;

use PHPUnit_Framework_TestCase as TestCase;
use Zend\Mvc\Controller\Plugin\Forward as ForwardPlugin;
use Zend\View\Model\ModelInterface as ViewModel;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class ReplaceContentTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group unit
     * @testdox is a modifiable phrase
     */
    public function isModifiablePhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\ModifiablePhraseInterface', new ReplaceContent());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function implementsServiceLocatorAwareInterface()
    {
        $this->assertInstanceOf('Zend\ServiceManager\ServiceLocatorAwareInterface', new ReplaceContent());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function dispatchesAnotherControllerAction()
    {
        $forwardPlugin = $this->getMock('Zend\Mvc\Controller\Plugin\Forward');
        $forwardPlugin->expects($this->once())
                      ->method('dispatch')
                      ->with('UserController', array('action' => 'foo'));

        $viewModel = $this->getMockForAbstractClass('Zend\View\Model\ModelInterface');

        $container = $this->getContainerMockWithForwardPluginAndViewModel($forwardPlugin, $viewModel);

        $phrase = new ReplaceContent();
        $phrase->setOptions(array('controller' => 'UserController', 'route_params' => array('action' => 'foo')));
        $phrase->execute($container);
    }

    protected function getContainerMockWithForwardPluginAndViewModel(ForwardPlugin $forwardPlugin, ViewModel $viewModel)
    {
        $controller = $this->getMock('Zend\Mvc\Controller\AbstractActionController', array('forward'));
        $controller->expects($this->any())
                   ->method('forward')
                   ->will($this->returnValue($forwardPlugin));

        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $container->expects($this->any())
                  ->method('getController')
                  ->will($this->returnValue($controller));

        $container->expects($this->any())
                 ->method('getViewModel')
                 ->will($this->returnValue($viewModel));
        return $container;
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function setsViewModelVariableToControllerActionResult()
    {
        $forwardPlugin = $this->getMock('Zend\Mvc\Controller\Plugin\Forward');
        $forwardPlugin->expects($this->any())
                      ->method('dispatch')
                      ->will($this->returnValue('my-content'));

        $viewModel = $this->getMockForAbstractClass('Zend\View\Model\ModelInterface');

        $container = $this->getContainerMockWithForwardPluginAndViewModel($forwardPlugin, $viewModel);
        $container->expects($this->once())
                 ->method('setViewVariable')
                 ->with('content', 'my-content');

        $phrase = new ReplaceContent();
        $phrase->setOptions(array('controller' => 'UserController', 'route_params' => array('action' => 'foo')));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function setsTemplateOfTheViewModel()
    {
        $forwardPlugin = $this->getMock('Zend\Mvc\Controller\Plugin\Forward');
        $viewModel     = $this->getMockForAbstractClass('Zend\View\Model\ModelInterface');
        $viewModel->expects($this->once())
                  ->method('setTemplate')
                  ->with('dsl/replace-content');

        $container = $this->getContainerMockWithForwardPluginAndViewModel($forwardPlugin, $viewModel);

        $phrase = new ReplaceContent();
        $phrase->setOptions(array('controller' => 'UserController', 'route_params' => array('action' => 'foo')));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function canGetTheServiceLocator()
    {
        $serviceLocator = $this->getMockForAbstractClass('Zend\ServiceManager\ServiceLocatorInterface');

        $phrase = new ReplaceContent();
        $phrase->setServiceLocator($serviceLocator);
        $this->assertSame($serviceLocator, $phrase->getServiceLocator());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function detachesTheRouteNotFoundStrategyOn404ResponseCode()
    {
        $forwardPlugin = $this->getMock('Zend\Mvc\Controller\Plugin\Forward');
        $viewModel     = $this->getMock('Zend\View\Model\ModelInterface');

        $eventManager     = $this->getMockForAbstractClass('Zend\EventManager\EventManagerInterface');
        $route404Strategy = $this->getMockForAbstractClass('Zend\EventManager\ListenerAggregateInterface');
        $route404Strategy->expects($this->once())
                         ->method('detach')
                         ->with($eventManager);

        $viewManager = $this->getMock('Zend\Mvc\View\Http\ViewManager');
        $viewManager->expects($this->any())
                    ->method('getRouteNotFoundStrategy')
                    ->will($this->returnValue($route404Strategy));

        $serviceLocatorMap = array(array('ViewManager', $viewManager), array('EventManager', $eventManager));

        $serviceLocator = $this->getMockForAbstractClass('Zend\ServiceManager\ServiceLocatorInterface');
        $serviceLocator->expects($this->any())
                       ->method('get')
                       ->will($this->returnValueMap($serviceLocatorMap));

        $phrase = new ReplaceContent();
        $phrase->setServiceLocator($serviceLocator);
        $phrase->setOptions(array('controller' => 'UserController', 'route_params' => array('action' => 'foo')));
        $phrase->execute($this->getContainerMockWithForwardPluginAndViewModel($forwardPlugin, $viewModel));
    }
}
