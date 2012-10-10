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
class AssignTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group unit
     * @testdox is a modifiable phrase
     */
    public function isModifiablePhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\ModifiablePhraseInterface', new Assign(array()));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function canRetrieveVariableFromConstructorOptions()
    {
        $variable = 'example';
        $phrase   = new Assign(array($variable));
        $this->assertEquals($variable, $phrase->getVariable());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function canRetrieveAliasFromConstructorOptions()
    {
        $alias   = 'example';
        $phrase = new Assign(array('variable', $alias));
        $this->assertEquals($alias, $phrase->getAlias());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function canRetrieveAliasFromOptions()
    {
        $alias = 'example';

        $phrase = new Assign(array());
        $phrase->setOptions(array('alias' => $alias));

        $this->assertEquals($alias, $phrase->getAlias());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function canRetrieveVariableFromOptions()
    {
        $variable = 'example';

        $phrase = new Assign(array());
        $phrase->setOptions(array('variable' => $variable));

        $this->assertEquals($variable, $phrase->getVariable());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function setsViewVariable()
    {
        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $container->expects($this->once())
                  ->method('setViewVariable')
                  ->with('my alias', 'my variable');

        $phrase = new Assign(array('my variable', 'my alias'));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function setsArrayOfVariablesWhenNoAliasIsGiven()
    {
        $variables = array('foo' => 'bar', 'bar' => 'baz');

        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $container->expects($this->once())
                  ->method('setViewVariables')
                  ->with($variables);

        $phrase = new Assign(array($variables));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function setsArrayOfVariablesOnlyWhenNoAliasIsGiven()
    {
        $variables = array('foo' => 'bar', 'bar' => 'baz');

        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $container->expects($this->once())
                  ->method('setViewVariable')
                  ->with('my alias', $variables);

        $phrase = new Assign(array($variables, 'my alias'));
        $phrase->execute($container);
    }
}
