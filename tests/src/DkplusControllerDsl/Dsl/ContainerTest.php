<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl;

use PHPUnit_Framework_TestCase as TestCase;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class ContainerTest extends TestCase
{
    /** @var Container */
    private $container;

    /** @var \Zend\Stdlib\RequestInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $request;

    /** @var \Zend\Stdlib\ResponseInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $response;

    /** @var \Zend\View\Model\ModelInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $viewModel;

    protected function setUp()
    {
        $this->request    = $this->getMockForAbstractClass('Zend\Stdlib\RequestInterface');
        $this->response   = $this->getMockForAbstractClass('Zend\Stdlib\ResponseInterface');
        $this->controller = $this->getMock('Zend\Mvc\Controller\AbstractController');
        $this->controller->expects($this->any())
                          ->method('getRequest')
                          ->will($this->returnValue($this->request));
        $this->controller->expects($this->any())
                          ->method('getResponse')
                          ->will($this->returnValue($this->response));
        $this->viewModel  = $this->getMockForAbstractClass('Zend\View\Model\ModelInterface');
        $this->container  = new Container($this->controller, $this->viewModel);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @testdox is a dsl container
     */
    public function isDslContainer()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\ContainerInterface', $this->container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function providesControllerAccess()
    {
        $this->assertSame($this->controller, $this->container->getController());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function providesRequestAccess()
    {
        $this->assertSame($this->request, $this->container->getRequest());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function providesResponseAccess()
    {
        $this->assertSame($this->response, $this->container->getResponse());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canOverwriteResponse()
    {
        $response = $this->getMockForAbstractClass('Zend\Stdlib\ResponseInterface');
        $this->container->setResponse($response);
        $this->assertSame($response, $this->container->getResponse());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @expectedException BadMethodCallException
     * @expectedExceptionMessage Cannot overwrite response when he is locked
     */
    public function cannotOverwriteResponseWhenHeIsLocked()
    {
        $this->container->lockResponse();
        $this->container->setResponse($this->getMockForAbstractClass('Zend\Stdlib\ResponseInterface'));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function providesAccessToTheViewModel()
    {
        $this->assertSame($this->viewModel, $this->container->getViewModel());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canOverwriteTheViewModel()
    {
        $viewModel = $this->getMockForAbstractClass('Zend\View\Model\ModelInterface');
        $this->container->setViewModel($viewModel);
        $this->assertSame($viewModel, $this->container->getViewModel());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @expectedException BadMethodCallException
     * @expectedExceptionMessage Cannot overwrite the view model when it is locked
     */
    public function cannotOverwriteTheViewModelWhenItIsLocked()
    {
        $this->container->lockViewModel();
        $this->container->setViewModel($this->getMockForAbstractClass('Zend\View\Model\ModelInterface'));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function hasInitiallyNoViewVariables()
    {
        $this->assertCount(0, $this->container->getViewVariables());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canHaveViewVariables()
    {
        $this->container->setViewVariable('foo', 'bar');
        $this->assertSame(array('foo' => 'bar'), $this->container->getViewVariables());
        return $this->container;
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @depends canHaveViewVariables
     */
    public function canOverwriteViewVariables(Container $container)
    {
        $container->setViewVariable('foo', 'baz');
        $this->assertSame(array('foo' => 'baz'), $container->getViewVariables());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function setsMultipleVariableAtOnce()
    {
        $this->container->setViewVariables(array('foo' => 'baz', 'bar' => 'baz'));
        $this->assertSame(array('foo' => 'baz', 'bar' => 'baz'), $this->container->getViewVariables());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function doesNotReplaceViewVariablesBySettingMultiplesAtOnce()
    {
        $this->container->setViewVariables(array('foo' => 'baz'));
        $this->container->setViewVariables(array('bar' => 'baz'));
        $this->assertSame(array('foo' => 'baz', 'bar' => 'baz'), $this->container->getViewVariables());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function isInitiallyNotTerminated()
    {
        $this->assertFalse($this->container->isTerminated());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canBeTerminated()
    {
        $this->container->terminate();
        $this->assertTrue($this->container->isTerminated());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canHaveVariables()
    {
        $this->container->setVariable('foo', 'bar');
        $this->assertSame('bar', $this->container->getVariable('foo'));
        return $this->container;
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @depends canHaveVariables
     */
    public function canOverwriteVariables(Container $container)
    {
        $container->setVariable('foo', 'baz');
        $this->assertSame('baz', $container->getVariable('foo'));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage There is no variable 'foo' stored
     */
    public function throwsExceptionOnAccessingNonExistingVariables()
    {
        $this->container->getVariable('foo');
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function hasTheViewModelAsDefaultResult()
    {
        $this->assertSame($this->viewModel, $this->container->getResult());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function returnsTheResponseAsResultIfHeHasBeenSetLast()
    {
        $response = $this->getMockForAbstractClass('Zend\Stdlib\ResponseInterface');
        $this->container->setResponse($response);

        $this->assertSame($response, $this->container->getResult());

        return $this->container;
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @depends returnsTheResponseAsResultIfHeHasBeenSetLast
     */
    public function returnsTheViewModelAsResultIfItHasBeenSetLast(Container $container)
    {
        $viewModel = $this->getMockForAbstractClass('Zend\View\Model\ModelInterface');
        $container->setViewModel($viewModel);

        $this->assertSame($viewModel, $container->getResult());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function setsViewVariablesByReturningTheViewModelAsResult()
    {
        $variables = array('foo' => 'bar', 'bar' => 'baz');
        foreach ($variables as $key => $value) {
            $this->container->setViewVariable($key, $value);
        }

        $this->viewModel->expects($this->once())
                        ->method('setVariables')
                        ->with($variables);

        $this->container->getResult();
    }
}

