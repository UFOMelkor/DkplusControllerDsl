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
class WithPhraseTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @testdox is a phrase
     */
    public function isPhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\PhraseInterface', new WithPhrase());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function isNoExecutablePhrase()
    {
        $this->assertNotInstanceOf('DkplusControllerDsl\Dsl\Phrase\ExecutablePhraseInterface', new WithPhrase());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function isNoPrePhrase()
    {
        $this->assertNotInstanceOf('DkplusControllerDsl\Dsl\Phrase\PrePhraseInterface', new WithPhrase());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function isNoPostPhrase()
    {
        $this->assertNotInstanceOf('DkplusControllerDsl\Dsl\Phrase\PostPhraseInterface', new WithPhrase());
    }
}
