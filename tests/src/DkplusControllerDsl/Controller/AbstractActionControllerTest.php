<?php
/**
 * @category   DkplusTest
 * @package    ControllerDsl
 * @subpackage Controller
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Controller;

use PHPUnit_Framework_TestCase as TestCase;

/**
 * @category   DkplusTest
 * @package    ControllerDsl
 * @subpackage Controller
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class AbstractActionControllerTest extends TestCase
{
    /** @var AbstractActionController|\PHPUnit_Framework_MockObject_MockObject */
    private $controller;

    /** @var \Zend\Mvc\MvcEvent|\PHPUnit_Framework_MockObject_MockObject */
    private $event;

    protected function setUp()
    {
        $routeMatch = $this->getMockBuilder('Zend\Mvc\Router\RouteMatch')
                           ->disableOriginalConstructor()
                           ->getMock();
        $routeMatch->expects($this->any())
                   ->method('getParam')
                   ->will($this->returnValue('test'));

        $this->event = $this->getMock('Zend\Mvc\MvcEvent');
        $this->event->expects($this->any())
                    ->method('getRouteMatch')
                    ->will($this->returnValue($routeMatch));

        $this->controller = $this->getMock(
            'DkplusControllerDsl\Controller\AbstractActionController',
            array('testAction')
        );
    }

    /**
     * @test
     * @group Component/Controller
     * @group Module/DkplusControllerDsl
     */
    public function isAnActionController()
    {
        $this->assertInstanceOf('Zend\Mvc\Controller\AbstractActionController', $this->controller);
    }

    /**
     * @test
     * @group Component/Controller
     * @group Module/DkplusControllerDsl
     */
    public function worksForViewModelResultsLikeTheBaseController()
    {
        $viewModel = $this->getMockForAbstractClass('Zend\View\Model\ModelInterface');

        $this->controller->expects($this->any())
                         ->method('testAction')
                         ->will($this->returnValue($viewModel));

        $this->event->expects($this->once())
                    ->method('setResult')
                    ->with($viewModel);

        $this->assertSame($viewModel, $this->controller->onDispatch($this->event));
    }

    /**
     * @test
     * @group Component/Controller
     * @group Module/DkplusControllerDsl
     */
    public function worksForResponseResultsLikeTheBaseController()
    {
        $response = $this->getMockForAbstractClass('Zend\Stdlib\ResponseInterface');

        $this->controller->expects($this->any())
                         ->method('testAction')
                         ->will($this->returnValue($response));

        $this->event->expects($this->once())
                    ->method('setResult')
                    ->with($response);

        $this->assertSame($response, $this->controller->onDispatch($this->event));
    }

    /**
     * @test
     * @group Component/Controller
     * @group Module/DkplusControllerDsl
     */
    public function executesDslResults()
    {
        $dslResult = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\DslInterface');
        $dslResult->expects($this->once())
                  ->method('execute');

        $this->controller->expects($this->any())
                         ->method('testAction')
                         ->will($this->returnValue($dslResult));

        $this->controller->onDispatch($this->event);
    }

    /**
     * @test
     * @group Component/Controller
     * @group Module/DkplusControllerDsl
     */
    public function returnsResultOfDslExecution()
    {
        $viewModel = $this->getMockForAbstractClass('Zend\View\Model\ModelInterface');

        $dsl = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\DslInterface');
        $dsl->expects($this->any())
            ->method('execute')
            ->will($this->returnValue($viewModel));

        $this->controller->expects($this->any())
                         ->method('testAction')
                         ->will($this->returnValue($dsl));

        $this->event->expects($this->at(2))
                    ->method('setResult')
                    ->with($viewModel);

        $this->assertSame($viewModel, $this->controller->onDispatch($this->event));
    }
}
