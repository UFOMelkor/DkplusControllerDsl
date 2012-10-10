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
class InfoTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group unit
     * @testdox is a pre phrase
     */
    public function isPrePhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\PrePhraseInterface', new Info());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function hasTypeOptionInfo()
    {
        $phrase = new Info();
        $this->assertSame(array('type' => 'info'), $phrase->getOptions());
    }
}
