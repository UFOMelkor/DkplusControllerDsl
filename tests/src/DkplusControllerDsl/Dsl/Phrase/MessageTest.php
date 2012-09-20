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
class MessageTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @testdox is a modifiable phrase
     */
    public function isModifiablePhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\ModifiablePhraseInterface', new Message(array()));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canRetrieveMessageFromConstructorOptions()
    {
        $message = 'i have something te say';

        $phrase = new Message(array($message));
        $this->assertEquals($message, $phrase->getMessage());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canRetrieveNamespaceFromConstructorOptions()
    {
        $namespace = 'success';

        $phrase = new Message(array('foo', $namespace));
        $this->assertEquals($namespace, $phrase->getNamespace());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canRetrieveNamespaceFromOptions()
    {
        $namespace = 'success';

        $phrase = new Message(array());
        $phrase->setOptions(array('type' => $namespace));
        $this->assertEquals($namespace, $phrase->getNamespace());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function hasDefaultNamespaceDefault()
    {
        $phrase = new Message(array());
        $this->assertEquals('default', $phrase->getNamespace());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function addsFlashMessage()
    {
        $message = 'veritas dicendum est';

        $flashMessenger = $this->getMock('Zend\Mvc\Controller\Plugin\FlashMessenger');
        $flashMessenger->expects($this->once())
                       ->method('addMessage')
                       ->with($message);

        $container = $this->getContainerMockFlashMessenger($flashMessenger);

        $phrase = new Message(array($message));
        $phrase->execute($container);
    }

    private function getContainerMockFlashMessenger($messenger)
    {
        $controller = $this->getMockBuilder('Zend\Mvc\Controller\AbstractActionController')
                           ->setMethods(array('flashMessenger'))
                           ->getMock();
        $controller->expects($this->any())
                   ->method('flashMessenger')
                   ->will($this->returnValue($messenger));

        $container  = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $container->expects($this->any())
                  ->method('getController')
                  ->will($this->returnValue($controller));

        return $container;
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function usesTheGivenNamespace()
    {
        $namespace = 'error';

        $flashMessenger = $this->getMock('Zend\Mvc\Controller\Plugin\FlashMessenger');
        $flashMessenger->expects($this->at(0))
                       ->method('setNamespace')
                       ->with($namespace);
        $flashMessenger->expects($this->at(1))
                       ->method('addMessage');

        $container = $this->getContainerMockFlashMessenger($flashMessenger);

        $phrase = new Message(array('foo', $namespace));
        $phrase->execute($container);
    }
}

