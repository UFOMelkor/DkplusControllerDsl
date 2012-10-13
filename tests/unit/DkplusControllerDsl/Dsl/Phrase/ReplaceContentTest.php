<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl\Phrase;

use DkplusUnitTest\TestCase;
use Zend\Mvc\Controller\Plugin\Forward as ForwardPlugin;
use Zend\View\Model\ModelInterface as ViewModel;
use Zend\Http\Response;
use Zend\Mvc\Router\RouteMatch;

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
    public function dispatchesAnotherControllerAction()
    {
        $viewModel     = $this->getMock('Zend\View\Model\ModelInterface');
        $forwardPlugin = $this->getMock('Zend\Mvc\Controller\Plugin\Forward');
        $forwardPlugin->expects($this->once())
                      ->method('dispatch')
                      ->with('UserController', array('action' => 'foo'))
                      ->will($this->returnValue($viewModel));

        $container = $this->getContainerMock($forwardPlugin, $viewModel);

        $phrase = new ReplaceContent();
        $phrase->setOptions(array('controller' => 'UserController', 'route_params' => array('action' => 'foo')));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function setsViewModelToForwardResult()
    {
        $viewModel = $this->getMockForAbstractClass('Zend\View\Model\ModelInterface');

        $container = $this->getContainerMock(null, $viewModel);
        $container->expects($this->once())
                 ->method('setViewModel')
                 ->with($viewModel);

        $phrase = new ReplaceContent();
        $phrase->setOptions(array('controller' => 'UserController', 'route_params' => array('action' => 'foo')));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     * @testdox can set a route and route params by merging
     */
    public function canSetRouteAndRouteParamsByMerging()
    {
        $routeMatch = $this->getMockIgnoringConstructor(
            'Zend\Mvc\Router\RouteMatch',
            array('merge', 'setMatchedRouteName', 'getMatchedRouteName')
        );
        $routeMatch->expects($this->once())
                   ->method('merge')
                   ->with($this->isInstanceOf(\get_class($routeMatch)));

        $container = $this->getContainerMock(null, null, null, $routeMatch);

        $phrase = new ReplaceContent();
        $phrase->setOptions(
            array(
                'route'        => 'my/route',
                'controller'   => 'UserController',
                'route_params' => array('action' => 'foo')
            )
        );
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function setsTheResponseCodeBeforeForwardTo200AndAfterBackToTheOld()
    {
        $response = $this->getMock('Zend\Http\Response');
        $response->expects($this->at(0))
                 ->method('getStatusCode')
                 ->will($this->returnValue(400));
        $response->expects($this->at(1))
                 ->method('setStatusCode')
                 ->with(200);
        $response->expects($this->at(2))
                 ->method('setStatusCode')
                 ->with(400);

        $container = $this->getContainerMock(null, null, $response);

        $phrase = new ReplaceContent();
        $phrase->setOptions(
            array(
                'controller'   => 'UserController',
                'route_params' => array('action' => 'foo')
            )
        );
        $phrase->execute($container);
    }

    /**
     * @param \Zend\Mvc\Controller\Plugin\Forward $forwardPlugin
     * @param \Zend\View\Model\ModelInterface $viewModel
     * @param \Zend\Http\Response $response
     * @param \Zend\Mvc\Router\RouteMatch $routeMatch
     * @return \DkplusControllerDsl\Dsl\ContainerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getContainerMock(
        ForwardPlugin $forwardPlugin = null,
        ViewModel $viewModel = null,
        Response $response = null,
        RouteMatch $routeMatch = null
    ) {
        if (!$viewModel) {
            $viewModel = $this->getMock('Zend\View\Model\ModelInterface');
        }
        if (!$forwardPlugin) {
            $forwardPlugin = $this->getMock('Zend\Mvc\Controller\Plugin\Forward');
            $forwardPlugin->expects($this->any())
                          ->method('dispatch')
                          ->will($this->returnValue($viewModel));
        }
        if (!$routeMatch) {
            $routeMatch = $this->getMockIgnoringConstructor(
                'Zend\Mvc\Router\RouteMatch',
                array('merge', 'setMatchedRouteName', 'getMatchedRouteName')
            );
        }

        if (!$response) {
            $response = $this->getMock('Zend\Http\Response');
            $response->expects($this->any())
                     ->method('getStatusCode')
                     ->will($this->returnValue(200));
        }

        $event = $this->getMockIgnoringConstructor('Zend\Mvc\MvcEvent');
        $event->expects($this->any())
              ->method('getRouteMatch')
              ->will($this->returnValue($routeMatch));

        $controller = $this->getMock('Zend\Mvc\Controller\AbstractActionController', array('getEvent', 'forward'));
        $controller->expects($this->any())
                   ->method('forward')
                   ->will($this->returnValue($forwardPlugin));

        $controller->expects($this->any())
                   ->method('getEvent')
                   ->will($this->returnValue($event));

        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $container->expects($this->any())
                  ->method('getController')
                  ->will($this->returnValue($controller));
        $container->expects($this->any())
                  ->method('getResponse')
                  ->will($this->returnValue($response));

        $container->expects($this->any())
                 ->method('getViewModel')
                 ->will($this->returnValue($viewModel));
        return $container;
    }
}
