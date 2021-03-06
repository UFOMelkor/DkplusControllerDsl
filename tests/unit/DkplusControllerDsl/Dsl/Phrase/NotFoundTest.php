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
class NotFoundTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group unit
     * @testdox is a pre phrase
     */
    public function isPrePhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\PrePhraseInterface', new NotFound());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function isAnExecutablePhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\ExecutablePhraseInterface', new NotFound());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function hasTypeOption404NotFound()
    {
        $phrase = new NotFound();
        $this->assertSame(array('type' => '404-not-found'), $phrase->getOptions());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function sets404ResponseCode()
    {
        $response = $this->getMock('Zend\Http\Response');
        $response->expects($this->once())
                 ->method('setStatusCode')
                 ->with(404);

        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $container->expects($this->any())
                  ->method('getResponse')
                  ->will($this->returnValue($response));

        $phrase = new NotFound();
        $phrase->execute($container);
    }
}
