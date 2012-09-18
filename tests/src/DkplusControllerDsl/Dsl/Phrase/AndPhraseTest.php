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
class AndPhraseTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @testdox is a phrase
     */
    public function isPhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\PhraseInterface', new AndPhrase());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function isNoExecutablePhrase()
    {
        $this->assertNotInstanceOf('DkplusControllerDsl\Dsl\Phrase\ExecutablePhraseInterface', new AndPhrase());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function isNoPrePhrase()
    {
        $this->assertNotInstanceOf('DkplusControllerDsl\Dsl\Phrase\PrePhraseInterface', new AndPhrase());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function isNoPostPhrase()
    {
        $this->assertNotInstanceOf('DkplusControllerDsl\Dsl\Phrase\PostPhraseInterface', new AndPhrase());
    }
}

