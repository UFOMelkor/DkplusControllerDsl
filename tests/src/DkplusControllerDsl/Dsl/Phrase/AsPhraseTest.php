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
class AsPhraseTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @testdox is a post phrase
     */
    public function isPostPhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\PostPhraseInterface', new AsPhrase(array()));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canRetrieveAliasFromConstructorOptions()
    {
        $alias  = 'any alias';
        $phrase = new AsPhrase(array($alias));
        $this->assertEquals(array('alias' => $alias), $phrase->getOptions());
    }
}

