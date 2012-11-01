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
class RenderTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function isAnExecutablePhrase()
    {
        $this->assertInstanceOf(
            'DkplusControllerDsl\Dsl\Phrase\ExecutablePhraseInterface',
            new Render(array('crud/read.phtml'))
        );
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function rendersTheGivenTemplateWhenViewModelIsGiven()
    {
        $template = 'crud/create.phtml';

        $viewModel = $this->getMock('Zend\View\Model\ViewModel');
        $viewModel->expects($this->once())
                  ->method('setTemplate')
                  ->with($template);

        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $container->expects($this->any())
                  ->method('getViewModel')
                  ->will($this->returnValue($viewModel));

        $phrase = new Render(array($template));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function locksTheViewModelWhenViewModelIsGiven()
    {
        $viewModel = $this->getMock('Zend\View\Model\ViewModel');
        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $container->expects($this->any())
                  ->method('getViewModel')
                  ->will($this->returnValue($viewModel));
        $container->expects($this->once())
                  ->method('lockViewModel');

        $phrase = new Render(array('crud/update.phtml'));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     * @expectedException RuntimeException
     * @expectedExceptionMessage Needs an instance of Zend\View\Model\ViewModel as view model
     */
    public function throwsAnExceptionWhenAnotherModelIsGiven()
    {
        $viewModel = $this->getMockForAbstractClass('Zend\View\Model\ModelInterface');
        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $container->expects($this->any())
                  ->method('getViewModel')
                  ->will($this->returnValue($viewModel));

        $phrase = new Render(array('crud/update.phtml'));
        $phrase->execute($container);
    }
}
