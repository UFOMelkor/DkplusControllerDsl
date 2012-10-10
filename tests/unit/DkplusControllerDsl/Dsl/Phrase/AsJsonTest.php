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
class AsJsonTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function isAnExecutablePhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\ExecutablePhraseInterface', new AsJson(array()));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function setsJsonViewModel()
    {
        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $container->expects($this->once())
                  ->method('setViewModel')
                  ->with($this->isInstanceOf('Zend\View\Model\JsonModel'));

        $phrase = new AsJson(array());
        $phrase->execute($container);
    }
}
