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
class UrlTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group unit
     * @testdox is a post phrase
     */
    public function isPostPhrase()
    {
        $url = 'http://www.example.org/';
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\PostPhraseInterface', new Url(array($url)));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function canRetrieveUrlFromConstructorOptions()
    {
        $url    = 'http://www.example.org/';
        $phrase = new Url(array($url));
        $this->assertSame(array('url' => $url), $phrase->getOptions());
    }
}
