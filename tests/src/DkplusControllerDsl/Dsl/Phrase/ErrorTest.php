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
class ErrorTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @testdox is a pre phrase
     */
    public function isPrePhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\PrePhraseInterface', new Error());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function hasTypeOptionError()
    {
        $phrase = new Error();
        $this->assertSame(array('type' => 'error'), $phrase->getOptions());
    }
}
