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
class OnFailureTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function isAnExecutablePhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\ExecutablePhraseInterface', new OnFailure(array()));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function executesGivenDslIfFormIsInvalid()
    {
        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');
        $form->expects($this->any())
             ->method('isValid')
             ->will($this->returnValue(false));

        $container = $this->getContainerMock(false);
        $container->expects($this->any())
                  ->method('getVariable')
                  ->with('__FORM__')
                  ->will($this->returnValue($form));

        $failureHandler = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\DslInterface');
        $failureHandler->expects($this->once())
                       ->method('execute')
                       ->with($container);

        $phrase = new OnFailure(array($failureHandler));
        $phrase->execute($container);
    }

    /** @return \DkplusControllerDsl\Dsl\ContainerInterface|\PHPUnit_Framework_MockObject_MockObject */
    private function getContainerMock($isAjaxRequest)
    {
        $request = $this->getMock('Zend\Http\Request');
        $request->expects($this->any())
                ->method('isXmlHttpRequest')
                ->will($this->returnValue($isAjaxRequest));

        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $container->expects($this->any())
                  ->method('getRequest')
                  ->will($this->returnValue($request));

        return $container;
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function executesGivenDslOnlyIfFormIsInvalid()
    {
        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');
        $form->expects($this->any())
             ->method('isValid')
             ->will($this->returnValue(true));

        $container = $this->getContainerMock(false);
        $container->expects($this->any())
                  ->method('getVariable')
                  ->with('__FORM__')
                  ->will($this->returnValue($form));

        $failureHandler = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\DslInterface');
        $failureHandler->expects($this->never())
                       ->method('execute');

        $phrase = new OnFailure(array($failureHandler));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     * @testdox executes the given dsl not if a form exception is thrown
     */
    public function executesGivenDslNotIfFormExceptionIsThrown()
    {
        $exception = $this->getMockIgnoringConstructor('Zend\Form\Exception\DomainException');

        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');
        $form->expects($this->any())
             ->method('isValid')
             ->will($this->throwException($exception));

        $container = $this->getContainerMock(false);
        $container->expects($this->any())
                  ->method('getVariable')
                  ->with('__FORM__')
                  ->will($this->returnValue($form));

        $failureHandler = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\DslInterface');
        $failureHandler->expects($this->never())
                       ->method('execute');

        $phrase = new OnFailure(array($failureHandler));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function executesGivenDslNotIfAnAjaxRequestIsDetected()
    {
        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');
        $form->expects($this->any())
             ->method('isValid')
             ->will($this->returnValue(false));

        $container = $this->getContainerMock(true);
        $container->expects($this->any())
                  ->method('getVariable')
                  ->with('__FORM__')
                  ->will($this->returnValue($form));

        $failureHandler = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\DslInterface');
        $failureHandler->expects($this->never())
                       ->method('execute');

        $phrase = new OnFailure(array($failureHandler));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     * @testdox can have a callable as failure handler
     */
    public function canHaveCallableAsFailureHandler()
    {
        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');
        $form->expects($this->any())
             ->method('isValid')
             ->will($this->returnValue(false));

        $container = $this->getContainerMock(false);
        $container->expects($this->any())
                  ->method('getVariable')
                  ->with('__FORM__')
                  ->will($this->returnValue($form));

        $dsl = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\DslInterface');
        $dsl->expects($this->once())
            ->method('execute')
            ->with($container);

        $callable = $this->getMock('stdClass', array('failureHandler'));
        $callable->expects($this->once())
                 ->method('failureHandler')
                 ->will($this->returnValue($dsl));

        $phrase = new OnFailure(array(array($callable, 'failureHandler')));
        $phrase->execute($container);
    }
}
