<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl;

use DkplusUnitTest\TestCase;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class PrePostExecutorDecoratorTest extends TestCase
{
    /** @var ExecutorInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $decorated;

    /** @var PrePostExecutorDecorator */
    private $executor;

    protected function setUp()
    {
        $this->decorated = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ExecutorInterface');
        $this->executor  = new PrePostExecutorDecorator($this->decorated);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @testdox is a dsl executor
     */
    public function isDslExecutor()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\ExecutorInterface', $this->executor);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function refersExecutablePhrasesToTheDecoratedExecutor()
    {
        $executablePhrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\ExecutablePhraseInterface');
        $this->decorated->expects($this->once())
                        ->method('addPhrase')
                        ->with($executablePhrase);
        $this->executor->addPhrase($executablePhrase);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @expectedException RuntimeException
     * @expectedExceptionMessage Needs a modifiable phrase to be added before
     */
    public function throwsRuntimeExceptionWhenPostPhraseIsAddedButNoPhraseHasBeenAddedBefore()
    {
        $postPhrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\PostPhraseInterface');
        $this->executor->addPhrase($postPhrase);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @expectedException RuntimeException
     * @expectedExceptionMessage Needs a modifiable phrase to be added before
     */
    public function throwsRuntimeExceptionWhenPostPhraseIsAddedButNoModifiablePhraseHasBeenAddedBefore()
    {
        $executablePhrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\ExecutablePhraseInterface');
        $this->executor->addPhrase($executablePhrase);

        $postPhrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\PostPhraseInterface');
        $this->executor->addPhrase($postPhrase);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function refersOptionsOfPostPhraseToModifiablePhrases()
    {
        $postOptions = array('foo' => 'bar', 'bar' => 'baz');

        $modifiablePhrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\ModifiablePhraseInterface');
        $modifiablePhrase->expects($this->once())
                         ->method('setOptions')
                         ->with($postOptions);

        $postPhrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\PostPhraseInterface');
        $postPhrase->expects($this->any())
                   ->method('getOptions')
                   ->will($this->returnValue($postOptions));

        $this->executor->addPhrase($modifiablePhrase);
        $this->executor->addPhrase($postPhrase);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function refersOptionsOfMultiplePostPhraseToModifiablePhrases()
    {
        $firstPostOptions  = array('foo' => 'bar', 'bar' => 'baz');
        $secondPostOptions = array('baz' => 'foo');

        $modifiablePhrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\ModifiablePhraseInterface');
        $modifiablePhrase->expects($this->at(0))
                         ->method('setOptions')
                         ->with($firstPostOptions);
        $modifiablePhrase->expects($this->at(1))
                         ->method('setOptions')
                         ->with($secondPostOptions);

        $firstPostPhrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\PostPhraseInterface');
        $firstPostPhrase->expects($this->any())
                        ->method('getOptions')
                        ->will($this->returnValue($firstPostOptions));

        $secondPostPhrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\PostPhraseInterface');
        $secondPostPhrase->expects($this->any())
                         ->method('getOptions')
                         ->will($this->returnValue($secondPostOptions));

        $this->executor->addPhrase($modifiablePhrase);
        $this->executor->addPhrase($firstPostPhrase);
        $this->executor->addPhrase($secondPostPhrase);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function refersOptionsOfPostPhraseOnlyToLastAddedModifiablePhrase()
    {
        $postOptions = array('foo' => 'bar', 'bar' => 'baz');

        $modifiablePhrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\ModifiablePhraseInterface');
        $modifiablePhrase->expects($this->never())
                         ->method('setOptions');

        $lastModifiablePhrase = $this->getMockForAbstractClass(
            'DkplusControllerDsl\Dsl\Phrase\ModifiablePhraseInterface'
        );
        $lastModifiablePhrase->expects($this->once())
                             ->method('setOptions')
                             ->with($postOptions);

        $postPhrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\PostPhraseInterface');
        $postPhrase->expects($this->any())
                   ->method('getOptions')
                   ->will($this->returnValue($postOptions));

        $this->executor->addPhrase($modifiablePhrase);
        $this->executor->addPhrase($lastModifiablePhrase);
        $this->executor->addPhrase($postPhrase);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function refersOptionsOfPrePhraseToModifiablePhrases()
    {
        $preOptions = array('foo' => 'bar', 'bar' => 'baz');

        $modifiablePhrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\ModifiablePhraseInterface');
        $modifiablePhrase->expects($this->once())
                         ->method('setOptions')
                         ->with($preOptions);

        $prePhrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\PrePhraseInterface');
        $prePhrase->expects($this->any())
                   ->method('getOptions')
                   ->will($this->returnValue($preOptions));

        $this->executor->addPhrase($prePhrase);
        $this->executor->addPhrase($modifiablePhrase);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function refersOptionsOfMultiplePrePhraseToModifiablePhrases()
    {
        $firstPreOptions  = array('foo' => 'bar', 'bar' => 'baz');
        $secondPreOptions = array('baz' => 'foo');

        $modifiablePhrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\ModifiablePhraseInterface');
        $modifiablePhrase->expects($this->at(0))
                         ->method('setOptions')
                         ->with($firstPreOptions);
        $modifiablePhrase->expects($this->at(1))
                         ->method('setOptions')
                         ->with($secondPreOptions);

        $firstPrePhrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\PrePhraseInterface');
        $firstPrePhrase->expects($this->any())
                       ->method('getOptions')
                       ->will($this->returnValue($firstPreOptions));

        $secondPrePhrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\PrePhraseInterface');
        $secondPrePhrase->expects($this->any())
                        ->method('getOptions')
                        ->will($this->returnValue($secondPreOptions));

        $this->executor->addPhrase($firstPrePhrase);
        $this->executor->addPhrase($secondPrePhrase);
        $this->executor->addPhrase($modifiablePhrase);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function refersOptionsOfPrePhraseOnlyToNextAddedModifiablePhrase()
    {
        $preOptions = array('foo' => 'bar', 'bar' => 'baz');

        $modifiablePhrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\ModifiablePhraseInterface');
        $modifiablePhrase->expects($this->never())
                         ->method('setOptions');

        $nextModifiablePhrase = $this->getMockForAbstractClass(
            'DkplusControllerDsl\Dsl\Phrase\ModifiablePhraseInterface'
        );
        $nextModifiablePhrase->expects($this->once())
                             ->method('setOptions')
                             ->with($preOptions);

        $prePhrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\PrePhraseInterface');
        $prePhrase->expects($this->any())
                  ->method('getOptions')
                  ->will($this->returnValue($preOptions));

        $this->executor->addPhrase($prePhrase);
        $this->executor->addPhrase($nextModifiablePhrase);
        $this->executor->addPhrase($modifiablePhrase);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function leavesExecutionToDecoratedExecutor()
    {
        $container = $this->getMockIgnoringConstructor('DkplusControllerDsl\Dsl\ContainerInterface');
        $viewModel = $this->getMockIgnoringConstructor('Zend\View\Model\ModelInterface');

        $this->decorated->expects($this->once())
                        ->method('execute')
                        ->with($container)
                        ->will($this->returnValue($viewModel));

        $this->assertSame($viewModel, $this->executor->execute($container));
    }
}

