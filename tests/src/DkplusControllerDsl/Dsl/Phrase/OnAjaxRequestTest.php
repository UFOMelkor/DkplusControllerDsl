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
class OnAjaxRequestTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @testdox is a post phrase
     */
    public function isPostPhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\PostPhraseInterface', new OnAjaxRequest(array()));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canRetrieveAjaxHandlerFromConstructorOptions()
    {
        $ajaxHandler = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\DslInterface');
        $phrase      = new OnAjaxRequest(array($ajaxHandler));
        $this->assertSame(array('onAjax' => $ajaxHandler), $phrase->getOptions());
    }
}

