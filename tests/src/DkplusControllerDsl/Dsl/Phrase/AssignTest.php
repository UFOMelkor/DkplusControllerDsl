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
     * @group Module/DkplusControllerDsl
     * @testdox is a modifiable phrase
     */
    public function isModifiablePhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\ModifiablePhraseInterface', new Assign(array()));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
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
     * @group Module/DkplusControllerDsl
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
     * @group Module/DkplusControllerDsl
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
     * @group Module/DkplusControllerDsl
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
     * @group Module/DkplusControllerDsl
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
}

