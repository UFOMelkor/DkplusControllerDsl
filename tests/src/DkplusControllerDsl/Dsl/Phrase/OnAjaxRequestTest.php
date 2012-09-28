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
class OnAjaxRequestTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function isAnExecutablePhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\ExecutablePhraseInterface', new OnAjaxRequest(array()));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function executesGivenDslIfAjaxRequestIsDetected()
    {
        $request = $this->getMock('Zend\Http\Request');
        $request->expects($this->any())
                ->method('isXmlHttpRequest')
                ->will($this->returnValue(true));

        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $container->expects($this->any())
                  ->method('getRequest')
                  ->will($this->returnValue($request));

        $ajaxHandler = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\DslInterface');
        $ajaxHandler->expects($this->once())
                    ->method('execute')
                    ->with($container);

        $phrase = new OnAjaxRequest(array($ajaxHandler));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function executesGivenDslOnlyIfAjaxRequestIsDetected()
    {
        $request = $this->getMock('Zend\Http\Request');
        $request->expects($this->any())
                ->method('isXmlHttpRequest')
                ->will($this->returnValue(false));

        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $container->expects($this->any())
                  ->method('getRequest')
                  ->will($this->returnValue($request));

        $ajaxHandler = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\DslInterface');
        $ajaxHandler->expects($this->never())
                    ->method('execute');

        $phrase = new OnAjaxRequest(array($ajaxHandler));
        $phrase->execute($container);
    }
}
