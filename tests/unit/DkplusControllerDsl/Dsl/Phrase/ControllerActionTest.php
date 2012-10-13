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
class ControllerActionTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group unit
     * @testdox is a post phrase
     */
    public function isPostPhrase()
    {
        $this->assertInstanceOf(
            'DkplusControllerDsl\Dsl\Phrase\PostPhraseInterface',
            new ControllerAction(array('user', 'index'))
        );
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function isAnOptionProvider()
    {
        $this->assertInstanceOf(
            'DkplusControllerDsl\Dsl\Phrase\OptionProvider',
            new ControllerAction(array('user', 'index'))
        );
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function hasTheControllerNameAsFirstOption()
    {
        $phrase  = new ControllerAction(array('user', 'index'));
        $options = $phrase->getOptionNames();

        $this->assertSame('controller', $options[0]);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function hasTheRouteParamsAsSecondOption()
    {
        $phrase  = new ControllerAction(array('user', 'index'));
        $options = $phrase->getOptionNames();

        $this->assertSame('route_params', $options[1]);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function mixesActionIntoRouteParams()
    {
        $phrase  = new ControllerAction(array('user', 'index', array('foo' => 'bar')));
        $options = $phrase->getOptions();

        $this->assertSame(array('action' => 'index', 'foo' => 'bar'), $options['route_params']);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function mustNotHaveRouteParams()
    {
        $phrase  = new ControllerAction(array('user', 'index'));
        $options = $phrase->getOptions();

        $this->assertSame(array('action' => 'index'), $options['route_params']);
    }
}
