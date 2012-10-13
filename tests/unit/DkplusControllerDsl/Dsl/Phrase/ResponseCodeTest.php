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
class ResponseCodeTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function isAnExecutablePhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\ExecutablePhraseInterface', new ResponseCode(array(200)));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function setsResponseCode()
    {
        $response = $this->getMock('Zend\Http\Response');
        $response->expects($this->once())
                 ->method('setStatusCode')
                 ->with(404);

        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $container->expects($this->any())
                  ->method('getResponse')
                  ->will($this->returnValue($response));

        $phrase = new ResponseCode(array(404));
        $phrase->execute($container);
    }
}
