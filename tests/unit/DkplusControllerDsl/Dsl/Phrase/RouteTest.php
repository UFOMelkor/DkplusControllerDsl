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
class RouteTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group unit
     * @testdox is a post phrase
     */
    public function isPostPhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\PostPhraseInterface', new Route(array()));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function canRetrieveRouteFromConstructorOptions()
    {
        $route  = 'home';
        $phrase = new Route(array($route));
        $this->assertSame(array('route' => $route), $phrase->getOptions());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function canRetrieveRouteParametersFromConstructorOptions()
    {
        $parameters  = array('foo' => 'bar');

        $phrase = new Route(array('home', $parameters));
        $result = $phrase->getOptions();

        $this->assertSame($parameters, $result['with']);
    }
}
