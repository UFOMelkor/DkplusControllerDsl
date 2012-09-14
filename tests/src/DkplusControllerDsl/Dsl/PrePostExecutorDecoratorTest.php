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
     * @expectedExceptionMessage Needs a executable phrase to be added before
     */
    public function throwsRuntimeExceptionWhenPostPhraseIsAddedButNoExecutableHasBeenAddedBefore()
    {
        $postPhrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\PostPhraseInterface');
        $this->executor->addPhrase($postPhrase);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function refersOptionsOfPostPhraseToExecutablePhrases()
    {
        $postOptions = array('foo' => 'bar', 'bar' => 'baz');

        $executablePhrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\ExecutablePhraseInterface');
        $executablePhrase->expects($this->once())
                         ->method('setOptions')
                         ->with($postOptions);

        $postPhrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\PostPhraseInterface');
        $postPhrase->expects($this->any())
                   ->method('getOptions')
                   ->will($this->returnValue($postOptions));

        $this->executor->addPhrase($executablePhrase);
        $this->executor->addPhrase($postPhrase);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function refersOptionsOfMultiplePostPhraseToExecutablePhrases()
    {
        $firstPostOptions  = array('foo' => 'bar', 'bar' => 'baz');
        $secondPostOptions = array('baz' => 'foo');

        $executablePhrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\ExecutablePhraseInterface');
        $executablePhrase->expects($this->at(0))
                         ->method('setOptions')
                         ->with($firstPostOptions);
        $executablePhrase->expects($this->at(1))
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

        $this->executor->addPhrase($executablePhrase);
        $this->executor->addPhrase($firstPostPhrase);
        $this->executor->addPhrase($secondPostPhrase);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function refersOptionsOfPostPhraseOnlyToLastAddedExecutablePhrase()
    {
        $postOptions = array('foo' => 'bar', 'bar' => 'baz');

        $executablePhrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\ExecutablePhraseInterface');
        $executablePhrase->expects($this->never())
                         ->method('setOptions');

        $lastExecutablePhrase = $this->getMockForAbstractClass(
            'DkplusControllerDsl\Dsl\Phrase\ExecutablePhraseInterface'
        );
        $lastExecutablePhrase->expects($this->once())
                             ->method('setOptions')
                             ->with($postOptions);

        $postPhrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\PostPhraseInterface');
        $postPhrase->expects($this->any())
                   ->method('getOptions')
                   ->will($this->returnValue($postOptions));

        $this->executor->addPhrase($executablePhrase);
        $this->executor->addPhrase($lastExecutablePhrase);
        $this->executor->addPhrase($postPhrase);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function refersOptionsOfPrePhraseToExecutablePhrases()
    {
        $preOptions = array('foo' => 'bar', 'bar' => 'baz');

        $executablePhrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\ExecutablePhraseInterface');
        $executablePhrase->expects($this->once())
                         ->method('setOptions')
                         ->with($preOptions);

        $prePhrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\PrePhraseInterface');
        $prePhrase->expects($this->any())
                   ->method('getOptions')
                   ->will($this->returnValue($preOptions));

        $this->executor->addPhrase($prePhrase);
        $this->executor->addPhrase($executablePhrase);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function refersOptionsOfMultiplePrePhraseToExecutablePhrases()
    {
        $firstPreOptions  = array('foo' => 'bar', 'bar' => 'baz');
        $secondPreOptions = array('baz' => 'foo');

        $executablePhrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\ExecutablePhraseInterface');
        $executablePhrase->expects($this->at(0))
                         ->method('setOptions')
                         ->with($firstPreOptions);
        $executablePhrase->expects($this->at(1))
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
        $this->executor->addPhrase($executablePhrase);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function refersOptionsOfPrePhraseOnlyToNextAddedExecutablePhrase()
    {
        $preOptions = array('foo' => 'bar', 'bar' => 'baz');

        $executablePhrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\ExecutablePhraseInterface');
        $executablePhrase->expects($this->never())
                         ->method('setOptions');

        $nextExecutablePhrase = $this->getMockForAbstractClass(
            'DkplusControllerDsl\Dsl\Phrase\ExecutablePhraseInterface'
        );
        $nextExecutablePhrase->expects($this->once())
                             ->method('setOptions')
                             ->with($preOptions);

        $prePhrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\PrePhraseInterface');
        $prePhrase->expects($this->any())
                  ->method('getOptions')
                  ->will($this->returnValue($preOptions));

        $this->executor->addPhrase($prePhrase);
        $this->executor->addPhrase($nextExecutablePhrase);
        $this->executor->addPhrase($executablePhrase);
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

