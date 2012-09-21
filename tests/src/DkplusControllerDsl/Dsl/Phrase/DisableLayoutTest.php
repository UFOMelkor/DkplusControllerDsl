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
class DisableLayoutTest extends TestCase
{
    /** @var \DkplusControllerDsl\Dsl\ContainerInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $container;

    protected function setUp()
    {
        parent::setUp();

        $viewModel       = $this->getMockForAbstractClass('Zend\View\Model\ModelInterface');
        $request         = $this->getMock('Zend\Http\Request');
        $this->container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $this->container->expects($this->any())
                        ->method('getViewModel')
                        ->will($this->returnValue($viewModel));
        $this->container->expects($this->any())
                        ->method('getRequest')
                        ->will($this->returnValue($request));
    }

        /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @testdox is a modifiable phrase
     */
    public function isModifiablePhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\ModifiablePhraseInterface', new DisableLayout(array()));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function locksViewModel()
    {
        $this->container->expects($this->once())
                        ->method('lockViewModel');

        $phrase = new DisableLayout(array());
        $phrase->execute($this->container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function disableLayout()
    {
        $this->container->getViewModel()->expects($this->once())
                                        ->method('terminate');

        $phrase = new DisableLayout(array());
        $phrase->execute($this->container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canBeDisabledOnNonAjaxRequest()
    {
        $this->container->expects($this->never())
                        ->method('lockViewModel');

        $this->container->getViewModel()->expects($this->never())
                                        ->method('terminate');

        $phrase = new DisableLayout(array());
        $phrase->setOptions(array('onAjax' => null));
        $phrase->execute($this->container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function willBeEnabledOnAjaxAnyway()
    {
        $this->container->expects($this->once())
                        ->method('lockViewModel');
        $this->container->getViewModel()->expects($this->once())
                                        ->method('terminate');

        $this->container->getRequest()->expects($this->any())
                                      ->method('isXmlHttpRequest')
                                      ->will($this->returnValue(true));

        $phrase = new DisableLayout(array());
        $phrase->setOptions(array('onAjax' => null));
        $phrase->execute($this->container);
    }
}

