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
class IntoTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group unit
     * @testdox is a post phrase
     */
    public function isPostPhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\PostPhraseInterface', new Into(array()));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function canRetrieveTargetFromConstructorOptions()
    {
        $target = 'storeFunction';
        $phrase = new Into(array($target));
        $this->assertSame(array('target' => $target), $phrase->getOptions());
    }
}
