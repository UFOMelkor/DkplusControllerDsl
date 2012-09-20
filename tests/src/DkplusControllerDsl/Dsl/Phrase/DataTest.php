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
class DataTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @testdox is a post phrase
     */
    public function isPostPhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\PostPhraseInterface', new Data(array()));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canRetrieveDataFromConstructorOptions()
    {
        $data = 'anything';

        $phrase = new Data(array($data));
        $this->assertSame(array('data' => $data), $phrase->getOptions());
    }
}

