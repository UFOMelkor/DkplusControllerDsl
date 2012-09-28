<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl\Executor;

use PHPUnit_Framework_TestCase as TestCase;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class ExecutorTest extends TestCase
{
    /** @var Executor */
    private $executor;

    protected function setUp()
    {
        $this->executor = new Executor();
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @testdox is a dsl executor
     */
    public function isDslExecutor()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Executor\ExecutorInterface', $this->executor);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function hasInitiallyNoPhrases()
    {
        $this->assertCount(0, $this->executor->getPhrases());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canGetMorePhrases()
    {
        $phrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\ExecutablePhraseInterface');
        $this->executor->addPhrase($phrase);
        $this->assertCount(1, $this->executor->getPhrases());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function ignoresNonExecutablePhrases()
    {
        $phrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\PhraseInterface');
        $this->executor->addPhrase($phrase);
        $this->assertCount(0, $this->executor->getPhrases());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function additionalPhrasesWillBeAddedAtTheEnd()
    {
        $phraseA = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\ExecutablePhraseInterface');
        $phraseB = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\ExecutablePhraseInterface');

        $this->executor->addPhrase($phraseA);
        $this->executor->addPhrase($phraseB);
        $this->assertSame(array($phraseA, $phraseB), $this->executor->getPhrases());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function returnsTheResultFromTheContainer()
    {
        $viewModel = $this->getMockForAbstractClass('Zend\View\Model\ModelInterface');

        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $container->expects($this->any())
                  ->method('getResult')
                  ->will($this->returnValue($viewModel));

        $this->assertSame($viewModel, $this->executor->execute($container));
    }


    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function doesNotCallOtherPhrasesIfTerminated()
    {
        $container = $this->getContainerMock();
        $container->expects($this->at(0))
                  ->method('isTerminated')
                  ->will($this->returnValue(true));

        $terminationPhrase = $this->getPhraseMock();

        $phraseAfter = $this->getPhraseMock();
        $phraseAfter->expects($this->never())
                    ->method('execute');

        $this->executor->addPhrase($terminationPhrase);
        $this->executor->addPhrase($phraseAfter);
        $this->executor->execute($container);
    }

    /** @return Phrase\PhraseInterface|\PHPUnit_Framework_MockObject_MockObject */
    private function getPhraseMock()
    {
        return $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\ExecutablePhraseInterface');
    }

    /** @return ContainerInterface|\PHPUnit_Framework_MockObject_MockObject */
    private function getContainerMock()
    {
        return $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
    }
}
