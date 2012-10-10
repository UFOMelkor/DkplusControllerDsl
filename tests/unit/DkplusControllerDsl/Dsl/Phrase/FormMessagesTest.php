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
class FormMessagesTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group unit
     * @testdox is a post phrase
     */
    public function isPostPhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\PostPhraseInterface', new FormMessages(array()));
    }
    /**
     * @test
     * @group Component/Dsl
     * @group unit
     * @testdox is a container aware phrase
     */
    public function isContainerAwarePhrase()
    {
        $this->assertInstanceOf(
            'DkplusControllerDsl\Dsl\Phrase\ContainerAwarePhraseInterface',
            new FormMessages(array())
        );
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function canRetrieveFormFromConstructorOptions()
    {
        $messages = array('foo' => 'bar');

        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');
        $form->expects($this->any())
             ->method('getMessages')
             ->will($this->returnValue($messages));

        $phrase = new FormMessages(array($form));
        $this->assertEquals(array('variable' => $messages), $phrase->getOptions());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function canRetrieveFormFromContainer()
    {
        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');

        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $container->expects($this->once())
                  ->method('getVariable')
                  ->with('form')
                  ->will($this->returnValue($form));

        $phrase = new FormMessages(array());
        $phrase->setContainer($container);
        $phrase->getOptions();
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function canUseConfigurableKeyToRetrieveFormFromContainer()
    {
        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');

        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $container->expects($this->once())
                  ->method('getVariable')
                  ->with('my-form')
                  ->will($this->returnValue($form));

        $phrase = new FormMessages(array('my-form'));
        $phrase->setContainer($container);
        $phrase->getOptions();
    }
}
