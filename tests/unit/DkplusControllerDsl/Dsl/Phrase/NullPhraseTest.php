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
class NullPhraseTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group unit
     * @testdox is a phrase
     */
    public function isPhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\PhraseInterface', new NullPhrase());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function isNoExecutablePhrase()
    {
        $this->assertNotInstanceOf('DkplusControllerDsl\Dsl\Phrase\ExecutablePhraseInterface', new NullPhrase());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function isNoPrePhrase()
    {
        $this->assertNotInstanceOf('DkplusControllerDsl\Dsl\Phrase\PrePhraseInterface', new NullPhrase());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function isNoPostPhrase()
    {
        $this->assertNotInstanceOf('DkplusControllerDsl\Dsl\Phrase\PostPhraseInterface', new NullPhrase());
    }
}
