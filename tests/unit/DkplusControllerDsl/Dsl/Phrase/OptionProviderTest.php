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
class OptionProviderTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function isAnOptionProviderPhrase()
    {
        $this->assertInstanceOf(
            'DkplusControllerDsl\Dsl\Phrase\OptionProviderPhraseInterface',
            new OptionProvider(array(), array())
        );
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function isNoPostPhrase()
    {
        $this->assertNotInstanceOf(
            'DkplusControllerDsl\Dsl\Phrase\PostPhraseInterface',
            new OptionProvider(array(), array())
        );
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function isNoPrePhrase()
    {
        $this->assertNotInstanceOf(
            'DkplusControllerDsl\Dsl\Phrase\PrePhraseInterface',
            new OptionProvider(array(), array())
        );
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     * @testdox can provide a single option
     */
    public function canProvideSingleOption()
    {
        $alias  = array('option');
        $values = array('value');

        $phrase = new OptionProvider($alias, $values);
        $this->assertEquals(array('option' => 'value'), $phrase->getOptions());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function canProvideMultipleOptions()
    {
        $alias  = array('foo', 'bar', 'baz');
        $values = array('my-foo', 'my-bar', 'my-baz');

        $phrase = new OptionProvider($alias, $values);
        $this->assertEquals(array('foo' => 'my-foo', 'bar' => 'my-bar', 'baz' => 'my-baz'), $phrase->getOptions());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function providesNamesOfOptions()
    {
        $alias  = array('foo', 'bar', 'baz');
        $values = array('my-foo', 'my-bar', 'my-baz');

        $phrase = new OptionProvider($alias, $values);
        $this->assertEquals($alias, $phrase->getOptionNames());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     * @expectedException RuntimeException
     * @expectedExceptionMessage 4 options provided but only 3 option-names
     */
    public function cannotHandleMoreValuesAsNames()
    {
        $alias  = array('foo', 'bar', 'baz');
        $values = array('my-foo', 'my-bar', 'my-baz', 'my-anything');

        new OptionProvider($alias, $values);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function canHandleMoreNamesAsValues()
    {
        $alias  = array('foo', 'bar', 'baz', 'anything');
        $values = array('my-foo', 'my-bar', 'my-baz');

        $phrase = new OptionProvider($alias, $values);
        $this->assertEquals(array('foo' => 'my-foo', 'bar' => 'my-bar', 'baz' => 'my-baz'), $phrase->getOptions());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     * @expectedException RuntimeException
     * @expectedExceptionMessage 4 option-names provided but only 3 options
     */
    public function throwsAnExceptionWhenMoreNamesAsValuesAreGivenAndWished()
    {
        $alias  = array('foo', 'bar', 'baz', 'anything');
        $values = array('my-foo', 'my-bar', 'my-baz');

        new OptionProvider($alias, $values, false);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     * @dataProvider provideBooleans
     * @param boolean $throwException
     */
    public function canConfigurateWhetherExceptionsShouldBeThrownOnMissingValues($throwException)
    {
        $phrase = new OptionProvider(array(), array(), !$throwException);
        $this->assertEquals($throwException, $phrase->isThrowingExceptionOnMissingValues());
    }

    public static function provideBooleans()
    {
        return array(array(true), array(false));
    }
}
