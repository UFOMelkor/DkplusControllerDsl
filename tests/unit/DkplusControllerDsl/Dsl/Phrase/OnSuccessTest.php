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
class OnSuccessTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function isAnExecutablePhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\ExecutablePhraseInterface', new OnSuccess(array()));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function executesGivenDslIfFormIsValid()
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

        $successHandler = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\DslInterface');
        $successHandler->expects($this->once())
                       ->method('execute')
                       ->with($container);

        $phrase = new OnSuccess(array($successHandler));
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
    public function executesGivenDslOnlyIfFormIsValid()
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

        $successHandler = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\DslInterface');
        $successHandler->expects($this->never())
                       ->method('execute');

        $phrase = new OnSuccess(array($successHandler));
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

        $successHandler = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\DslInterface');
        $successHandler->expects($this->never())
                       ->method('execute');

        $phrase = new OnSuccess(array($successHandler));
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
             ->will($this->returnValue(true));

        $container = $this->getContainerMock(true);
        $container->expects($this->any())
                  ->method('getVariable')
                  ->with('__FORM__')
                  ->will($this->returnValue($form));

        $successHandler = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\DslInterface');
        $successHandler->expects($this->never())
                       ->method('execute');

        $phrase = new OnSuccess(array($successHandler));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     * @testdox can have a callable as success handler
     */
    public function canHaveCallableAsSuccessHandler()
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

        $dsl = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\DslInterface');
        $dsl->expects($this->once())
            ->method('execute')
            ->with($container);

        $callable = $this->getMock('stdClass', array('successHandler'));
        $callable->expects($this->once())
                 ->method('successHandler')
                 ->will($this->returnValue($dsl));

        $phrase = new OnSuccess(array(array($callable, 'successHandler')));
        $phrase->execute($container);
    }
}
