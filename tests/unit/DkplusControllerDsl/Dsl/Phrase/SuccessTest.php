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
class SuccessTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group unit
     * @testdox is a pre phrase
     */
    public function isPrePhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\PrePhraseInterface', new Success());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function hasTypeOptionSuccess()
    {
        $phrase = new Success();
        $this->assertSame(array('type' => 'success'), $phrase->getOptions());
    }
}
