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
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\ExecutorInterface', $this->executor);
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
        $phrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\PhraseInterface');
        $this->executor->addPhrase($phrase);
        $this->assertCount(1, $this->executor->getPhrases());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function additionalPhrasesWillBeAddedAtTheEnd()
    {
        $phraseA = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\PhraseInterface');
        $phraseB = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\PhraseInterface');

        $this->executor->addPhrase($phraseA);
        $this->executor->addPhrase($phraseB);
        $this->assertSame(array($phraseA, $phraseB), $this->executor->getPhrases());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function initiallyReturnsTheViewModelWhenNoPhraseHasBeenAdded()
    {
        $viewModel = $this->getMockForAbstractClass('Zend\View\Model\ModelInterface');

        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $container->expects($this->any())
                  ->method('getViewModel')
                  ->will($this->returnValue($viewModel));

        $this->assertSame($viewModel, $this->executor->execute($container));
    }
}

