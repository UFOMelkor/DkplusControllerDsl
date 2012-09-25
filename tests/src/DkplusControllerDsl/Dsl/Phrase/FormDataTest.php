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
class FormDataTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @testdox is a container aware phrase
     */
    public function isContainerAwarePhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\ContainerAwarePhraseInterface', new FormData(array()));
    }
    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @testdox is a post phrase
     */
    public function isPostPhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\PostPhraseInterface', new FormData(array()));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function providesFormDataAsCallable()
    {
        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');

        $phrase  = new FormData(array($form));
        $options = $phrase->getOptions();
        $this->assertSame(array($form, 'getData'), $options['data']);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canGetFormFromContainer()
    {
        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');

        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $container->expects($this->once())
                  ->method('getVariable')
                  ->with('form')
                  ->will($this->returnValue($form));

        $phrase  = new FormData(array());
        $phrase->setContainer($container);

        $this->assertSame(array('data' => array($form, 'getData')), $phrase->getOptions());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canUseConfigurableKeyToGetFormFromContainer()
    {
        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');

        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $container->expects($this->once())
                  ->method('getVariable')
                  ->with('my-form')
                  ->will($this->returnValue($form));

        $phrase  = new FormData(array('my-form'));
        $phrase->setContainer($container);

        $this->assertSame(array('data' => array($form, 'getData')), $phrase->getOptions());
    }
}

