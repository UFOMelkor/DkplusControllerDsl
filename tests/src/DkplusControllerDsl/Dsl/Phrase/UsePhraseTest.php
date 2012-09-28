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
class UsePhraseTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @testdox is a modifiable phrase
     */
    public function isModifiablePhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\ModifiablePhraseInterface', new UsePhrase(array()));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @testdox is a pre phrase
     */
    public function isPrePhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\PrePhraseInterface', new UsePhrase(array()));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canRetrieveVariableFromConstructorOptions()
    {
        $variable = 'example';
        $phrase   = new UsePhrase(array($variable));
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
        $phrase = new UsePhrase(array('variable', $alias));
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

        $phrase = new UsePhrase(array());
        $phrase->setOptions(array('alias' => $alias));

        $this->assertEquals($alias, $phrase->getAlias());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function setsPhraseVariable()
    {
        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $container->expects($this->once())
                  ->method('setVariable')
                  ->with('my alias', 'my variable');

        $phrase = new UsePhrase(array('my variable', 'my alias'));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function usesFormAsAliasForFormsAutomatically()
    {
        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');

        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $container->expects($this->once())
                  ->method('setVariable')
                  ->with('form', $form);

        $phrase = new UsePhrase(array($form));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function usesFormAsAliasForFormsOnlyIfNoAliasIsGiven()
    {
        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');

        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $container->expects($this->once())
                  ->method('setVariable')
                  ->with('another alias', $form);

        $phrase = new UsePhrase(array($form, 'another alias'));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function providesVariableOption()
    {
        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');

        $phrase = new UsePhrase(array($form));

        $options = $phrase->getOptions();
        $this->assertEquals($form, $options['variable']);
    }
}
