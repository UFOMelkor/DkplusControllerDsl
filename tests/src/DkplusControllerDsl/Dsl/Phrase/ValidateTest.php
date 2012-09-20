<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl\Phrase;

use PHPUnit_Framework_TestCase as TestCase;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class ValidateTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @testdox is a modifiable phrase
     */
    public function isModifiablePhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\ModifiablePhraseInterface', new Validate(array()));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canRetrieveFormFromConstructorOptions()
    {
        $form   = $this->getMock('Zend\Form\Form');
        $phrase = new Validate(array($form));
        $this->assertEquals($form, $phrase->getForm());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canRetrieveValidationDataFromConstructorOptions()
    {
        $form   = $this->getMock('Zend\Form\Form');
        $data   = array('foo', 'bar');
        $phrase = new Validate(array($form, $data));
        $this->assertEquals($data, $phrase->getValidateAgainst());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canRetrieveValidationDataFromOptions()
    {
        $data   = array('foo', 'bar');
        $phrase = new Validate(array());
        $phrase->setOptions(array('against' => $data));
        $this->assertEquals($data, $phrase->getValidateAgainst());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canRetrieveAjaxHandlingFromOptions()
    {
        $handler = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\DslInterface');

        $phrase = new Validate(array());
        $phrase->setOptions(array('onAjax' => $handler));
        $this->assertEquals($handler, $phrase->getAjaxHandler());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canRetrieveSuccessHandlingFromOptions()
    {
        $handler = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\DslInterface');

        $phrase = new Validate(array());
        $phrase->setOptions(array('onSuccess' => $handler));
        $this->assertEquals($handler, $phrase->getSuccessHandler());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canRetrieveFailureHandlingFromOptions()
    {
        $handler = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\DslInterface');

        $phrase = new Validate(array());
        $phrase->setOptions(array('onFailure' => $handler));
        $this->assertEquals($handler, $phrase->getFailureHandler());
    }


    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function setsDataIntoForm()
    {
        $validationData = array('foo' => 'bar');

        $form = $this->getMock('Zend\Form\Form');
        $form->expects($this->once())
             ->method('setData')
             ->with($validationData);

        $container = $this->getContainerWithRequest();

        $phrase = new Validate(array($form, $validationData));
        $phrase->execute($container);
    }

    /** @return \DkplusControllerDsl\Dsl\ContainerInterface|\PHPUnit_Framework_MockObject_MockObject */
    private function getContainerWithRequest($ajaxRequest = false)
    {
        $request = $this->getMock('Zend\Http\Request');
        $request->expects($this->any())
                ->method('isXmlHttpRequest')
                ->will($this->returnValue($ajaxRequest));

        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $container->expects($this->any())
                  ->method('getRequest')
                  ->will($this->returnValue($request));
        return $container;
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canRetrieveFormFromContainerVariable()
    {
        $validationData = array('foo' => 'bar');

        $form = $this->getMock('Zend\Form\Form');
        $form->expects($this->once())
             ->method('setData')
             ->with($validationData);

        $container = $this->getContainerWithRequest();
        $container->expects($this->any())
                  ->method('getVariable')
                  ->with('form')
                  ->will($this->returnValue($form));

        $phrase = new Validate(array(null, $validationData));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function executesAjaxHandlerOnAjaxRequest()
    {
        $form      = $this->getMock('Zend\Form\Form');
        $container = $this->getContainerWithRequest(true);

        $ajaxHandler = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\DslInterface');
        $ajaxHandler->expects($this->once())
                    ->method('execute')
                    ->with($container);

        $phrase = new Validate(array($form));
        $phrase->setOptions(array('onAjax' => $ajaxHandler));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function executesSuccessHandlerWhenNoAjaxRequestAndFormIsValid()
    {
        $form = $this->getMock('Zend\Form\Form');
        $form->expects($this->any())
             ->method('isValid')
             ->will($this->returnValue(true));

        $container = $this->getContainerWithRequest(false);

        $successHandler = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\DslInterface');
        $successHandler->expects($this->once())
                       ->method('execute')
                       ->with($container);

        $phrase = new Validate(array($form, array('foo' => 'bar')));
        $phrase->setOptions(array('onSuccess' => $successHandler));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function executesFailureHandlerWhenNoAjaxRequestAndFormIsInvalid()
    {
        $form = $this->getMock('Zend\Form\Form');
        $form->expects($this->any())
             ->method('isValid')
             ->will($this->returnValue(false));

        $container = $this->getContainerWithRequest(false);

        $successHandler = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\DslInterface');
        $successHandler->expects($this->once())
                       ->method('execute')
                       ->with($container);

        $phrase = new Validate(array($form, array('foo' => 'bar')));
        $phrase->setOptions(array('onFailure' => $successHandler));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function executesNothingWhenNoAjaxRequestAndNoValidationDataAreGiven()
    {
        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');
        $form->expects($this->never())
             ->method('setData');

        $container = $this->getContainerWithRequest();
        $execDsl = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\DslInterface');
        $execDsl->expects($this->never())
                ->method('execute');

        $phrase = new Validate(array($form, array()));
        $phrase->setOptions(array('onSuccess' => $execDsl, 'onFailure' => $execDsl));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canUsePostData()
    {
        $postData = array('foo' => 'bar', 'bar' => 'baz');

        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');
        $form->expects($this->once())
             ->method('setData')
             ->with($postData);

        $container = $this->getContainerWithRequest();
        $request   = $container->getRequest();
        $request->expects($this->any())
                ->method('getPost')
                ->will($this->returnValue($postData));

        $phrase = new Validate(array($form, 'post'));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canUseQueryData()
    {
        $getData = array('foo' => 'bar', 'bar' => 'baz');

        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');
        $form->expects($this->once())
             ->method('setData')
             ->with($getData);

        $container = $this->getContainerWithRequest();
        $request   = $container->getRequest();
        $request->expects($this->any())
                ->method('getQuery')
                ->will($this->returnValue($getData));

        $phrase = new Validate(array($form, 'query'));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canUseDataStoredByPostRedirectGet()
    {
        $sessionData = array('foo' => 'bar', 'bar' => 'baz');

        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');
        $form->expects($this->once())
             ->method('setData')
             ->with($sessionData);

        $controller = $this->getMock('Zend\Mvc\Controller\AbstractActionController', array('postredirectget'));
        $controller->expects($this->any())
                   ->method('postredirectget')
                   ->will($this->returnValue($sessionData));

        $container = $this->getContainerWithRequest();
        $container->expects($this->any())
                  ->method('getController')
                  ->will($this->returnValue($controller));

        $phrase = new Validate(array($form, 'postredirectget'));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function doesNothingWhenUsingPrgAndFalseIsReturned()
    {
        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');

        $controller = $this->getMock('Zend\Mvc\Controller\AbstractActionController', array('postredirectget'));
        $controller->expects($this->any())
                   ->method('postredirectget')
                   ->will($this->returnValue(false));

        $container = $this->getContainerWithRequest();
        $container->expects($this->any())
                  ->method('getController')
                  ->will($this->returnValue($controller));

        $container->expects($this->never())
                  ->method('setResponse');
        $container->expects($this->never())
                  ->method('terminate');

        $execDsl = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\DslInterface');
        $execDsl->expects($this->never())
                ->method('execute');

        $phrase = new Validate(array($form, 'postredirectget'));
        $phrase->setOptions(array('onSuccess' => $execDsl, 'onFailure' => $execDsl));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function redirectsWhenUsingPostRedirectGetAndPostDataAreGiven()
    {

        $response = $this->getMockForAbstractClass('Zend\Stdlib\ResponseInterface');

        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');
        $form->expects($this->never())
             ->method('setData');

        $controller = $this->getMock('Zend\Mvc\Controller\AbstractActionController', array('postredirectget'));
        $controller->expects($this->any())
                   ->method('postredirectget')
                   ->will($this->returnValue($response));

        $container = $this->getContainerWithRequest();
        $container->expects($this->any())
                  ->method('getController')
                  ->will($this->returnValue($controller));
        $container->expects($this->once())
                  ->method('setResponse')
                  ->with($response);
        $container->expects($this->once())
                  ->method('terminate');

        $phrase = new Validate(array($form, 'postredirectget'));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function redirectsOnlyWhenNoAjaxRequest()
    {
        $postData = array('foo' => 'bar', 'baz' => 'bar');

        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');
        $form->expects($this->once())
             ->method('setData')
             ->with($postData);

        $container = $this->getContainerWithRequest(true);

        $request = $container->getRequest();
        $request->expects($this->any())
                ->method('getPost')
                ->will($this->returnValue($postData));

        $phrase = new Validate(array($form, 'postredirectget'));
        $phrase->execute($container);
    }
}

