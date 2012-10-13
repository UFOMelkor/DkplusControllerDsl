<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl\Phrase;

use PHPUnit_Framework_TestCase as TestCase;
use Zend\View\Model\ModelInterface as ViewModel;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class Ignore404NotFoundControllerTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function isAnExecutablePhrase()
    {
        $this->assertInstanceOf(
            'DkplusControllerDsl\Dsl\Phrase\ExecutablePhraseInterface',
            new Ignore404NotFoundController()
        );
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function implementsServiceLocatorAwareInterface()
    {
        $this->assertInstanceOf(
            'Zend\ServiceManager\ServiceLocatorAwareInterface',
            new Ignore404NotFoundController()
        );
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function canGetTheServiceLocator()
    {
        $serviceLocator = $this->getMockForAbstractClass('Zend\ServiceManager\ServiceLocatorInterface');

        $phrase = new Ignore404NotFoundController();
        $phrase->setServiceLocator($serviceLocator);
        $this->assertSame($serviceLocator, $phrase->getServiceLocator());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function setsTheRouteNotFoundTemplateOn404ResponseCode()
    {
        $viewModel = $this->getMock('Zend\View\Model\ModelInterface');
        $viewModel->expects($this->any())
                  ->method('getTemplate')
                  ->will($this->returnValue('my/template'));

        $route404Strategy = $this->getMock('Zend\Mvc\View\Http\RouteNotFoundStrategy');
        $route404Strategy->expects($this->once())
                         ->method('setNotFoundTemplate')
                         ->with('my/template');

        $viewManager = $this->getMock('Zend\Mvc\View\Http\ViewManager');
        $viewManager->expects($this->any())
                    ->method('getRouteNotFoundStrategy')
                    ->will($this->returnValue($route404Strategy));

        $serviceLocator = $this->getMockForAbstractClass('Zend\ServiceManager\ServiceLocatorInterface');
        $serviceLocator->expects($this->any())
                       ->method('get')
                       ->with('ViewManager')
                       ->will($this->returnValue($viewManager));

        $pluginLocator = $this->getMock('\Zend\Mvc\Controller\PluginManager');
        $pluginLocator->expects($this->any())
                      ->method('getServiceLocator')
                      ->will($this->returnValue($serviceLocator));

        $phrase = new Ignore404NotFoundController();
        $phrase->setServiceLocator($pluginLocator);
        $phrase->execute($this->getContainerMock($viewModel, 404));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function setsTheRouteNotFoundTemplateOnlyOn404ResponseCode()
    {
        $viewModel = $this->getMock('Zend\View\Model\ModelInterface');
        $viewModel->expects($this->any())
                  ->method('getTemplate')
                  ->will($this->returnValue('my/template'));

        $route404Strategy = $this->getMock('Zend\Mvc\View\Http\RouteNotFoundStrategy');
        $route404Strategy->expects($this->never())
                         ->method('setNotFoundTemplate');

        $viewManager = $this->getMock('Zend\Mvc\View\Http\ViewManager');
        $viewManager->expects($this->any())
                    ->method('getRouteNotFoundStrategy')
                    ->will($this->returnValue($route404Strategy));

        $serviceLocator = $this->getMockForAbstractClass('Zend\ServiceManager\ServiceLocatorInterface');
        $serviceLocator->expects($this->any())
                       ->method('get')
                       ->with('ViewManager')
                       ->will($this->returnValue($viewManager));

        $pluginLocator = $this->getMock('\Zend\Mvc\Controller\PluginManager');
        $pluginLocator->expects($this->any())
                      ->method('getServiceLocator')
                      ->will($this->returnValue($serviceLocator));

        $phrase = new Ignore404NotFoundController();
        $phrase->setServiceLocator($pluginLocator);
        $phrase->execute($this->getContainerMock($viewModel, 200));
    }

    /**
     * @param \Zend\View\Model\ModelInterface $viewModel
     * @param int $responseCode
     * @return \DkplusControllerDsl\Dsl\ContainerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getContainerMock(ViewModel $viewModel, $responseCode = 200)
    {
        $response = $this->getMock('Zend\Http\Response');
        $response->expects($this->any())
                 ->method('getStatusCode')
                 ->will($this->returnValue($responseCode));

        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');

        $container->expects($this->any())
                  ->method('getResponse')
                  ->will($this->returnValue($response));

        $container->expects($this->any())
                 ->method('getViewModel')
                 ->will($this->returnValue($viewModel));
        return $container;
    }
}
