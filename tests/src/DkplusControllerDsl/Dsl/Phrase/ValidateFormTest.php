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
        $handler = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\ExecutablePhraseInterface');

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
        $handler = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\ExecutablePhraseInterface');

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
        $handler = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\ExecutablePhraseInterface');

        $phrase = new ValidateForm(array());
        $phrase->setOptions(array('onFailure' => $handler));
        $this->assertEquals($handler, $phrase->getFailureHandler());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function validatesFormAgainstValidationData()
    {
        $validationData = array('foo' => 'bar');

        $form = $this->getMock('Zend\Form\Form');
        $form->expects($this->at(0))
             ->method('setData')
             ->with($validationData);
        $form->expects($this->at(1))
             ->method('isValid');

        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');

        $phrase = new ValidateForm(array($form, $validationData));
        $phrase->execute($container);
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
        $form->expects($this->at(0))
             ->method('setData')
             ->with($validationData);
        $form->expects($this->at(1))
             ->method('isValid');

        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $container->expects($this->any())
                  ->method('getVariable')
                  ->with('form')
                  ->will($this->returnValue($form));

        $phrase = new ValidateForm(array(null, $validationData));
        $phrase->execute($container);
    }
}

