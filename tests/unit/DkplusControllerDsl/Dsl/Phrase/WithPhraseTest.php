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
     * @group unit
     * @testdox is a post phrase
     */
    public function isPostPhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\PostPhraseInterface', new WithPhrase(array()));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     * @testdox is a post phrase
     */
    public function providesWithOption()
    {
        $phrase = new WithPhrase(array('foo'));
        $this->assertSame(array('with' => array('foo')), $phrase->getOptions());
    }
}
