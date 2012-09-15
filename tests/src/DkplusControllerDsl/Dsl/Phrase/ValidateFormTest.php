<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl\Phrase;

use DkplusUnitTest\TestCase;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class ValidateFormTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @testdox is a modifiable phrase
     */
    public function isModifiablePhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\ModifiablePhraseInterface', new ValidateForm(array()));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canRetrieveFormFromConstructorOptions()
    {
        $form   = $this->getMock('Zend\Form\Form');
        $phrase = new ValidateForm(array($form));
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
        $phrase = new ValidateForm(array($form, $data));
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
        $phrase = new ValidateForm(array());
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

        $phrase = new ValidateForm(array());
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

        $phrase = new ValidateForm(array());
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

        $phrase = new ValidateForm(array());
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

        $phrase = new ValidateForm(array($form, $validationData));
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

        $phrase = new ValidateForm(array(null, $validationData));
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

        $phrase = new ValidateForm(array($form));
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

        $phrase = new ValidateForm(array($form));
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

        $phrase = new ValidateForm(array($form));
        $phrase->setOptions(array('onFailure' => $successHandler));
        $phrase->execute($container);
    }
}

