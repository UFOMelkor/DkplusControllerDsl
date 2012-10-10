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
class FormTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group unit
     * @testdox is a container aware phrase
     */
    public function isContainerAwarePhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\ContainerAwarePhraseInterface', new Form(array()));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     * @testdox is a post phrase
     */
    public function isPostPhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\PostPhraseInterface', new Form(array()));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function providesFormOption()
    {
        $form   = $this->getMockForAbstractClass('Zend\Form\FormInterface');
        $phrase = new Form(array($form));
        $this->assertSame(array('form' => $form), $phrase->getOptions());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function canGetFormFromContainer()
    {
        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');

        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $container->expects($this->once())
                  ->method('getVariable')
                  ->with('form')
                  ->will($this->returnValue($form));

        $phrase  = new Form(array());
        $phrase->setContainer($container);

        $this->assertSame(array('form' => $form), $phrase->getOptions());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function canUseConfigurableKeyToGetFormFromContainer()
    {
        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');

        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $container->expects($this->once())
                  ->method('getVariable')
                  ->with('my-form')
                  ->will($this->returnValue($form));

        $phrase  = new Form(array('my-form'));
        $phrase->setContainer($container);

        $this->assertSame(array('form' => $form), $phrase->getOptions());
    }
}
