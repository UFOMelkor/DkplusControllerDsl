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
class AssignFormMessagesTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function isAnAssignPhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\Assign', new AssignFormMessages(array()));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canRetrieveFormFromConstructorOptions()
    {
        $messages = array('foo' => 'bar');

        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');
        $form->expects($this->any())
             ->method('getMessages')
             ->will($this->returnValue($messages));

        $phrase = new AssignFormMessages(array($form));
        $this->assertEquals($messages, $phrase->getVariable());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canRetrieveFormFromOptions()
    {
        $messages = array('foo' => 'bar');

        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');
        $form->expects($this->any())
             ->method('getMessages')
             ->will($this->returnValue($messages));

        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $container->expects($this->any())
                  ->method('getVariable')
                  ->with('form')
                  ->will($this->returnValue($form));
        $container->expects($this->once())
                  ->method('setViewVariables')
                  ->with($messages);

        $phrase = new AssignFormMessages(array());
        $phrase->execute($container);
    }
}

