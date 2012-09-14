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
    public function initiallyReturnsTheViewModelWhenNoPhraseHasBeenAdded()
    {
        $viewModel = $this->getMockForAbstractClass('Zend\View\Model\ModelInterface');

        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $container->expects($this->any())
                  ->method('getViewModel')
                  ->will($this->returnValue($viewModel));

        $this->assertSame($viewModel, $this->executor->execute($container));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @testdox returns a response when any phrase returns these response
     * @dataProvider providePhrasesWithoneReturningResponse
     */
    public function returnsResponseWhenAnyPhraseReturnsTheseResponse(array $phrases, $response)
    {
        $container = $this->getContainerMock();

        foreach ($phrases as $phrase) {
            $this->executor->addPhrase($phrase);
        }

        $this->assertSame($response, $this->executor->execute($container));
    }

    public function providePhrasesWithOneReturningResponse()
    {
        $response          = $this->getMockForAbstractClass('Zend\Stdlib\ResponseInterface');
        $returningResponse = $this->getPhraseMock();
        $returningResponse->expects($this->any())
                          ->method('execute')
                          ->will($this->returnValue($response));
        return array(
            array(array($returningResponse), $response),
            array(array($this->getPhraseMock(), $returningResponse), $response),
            array(array($returningResponse, $this->getPhraseMock()), $response),
            array(array($this->getPhraseMock(), $returningResponse, $this->getPhraseMock()), $response)
        );
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

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @testdox does not call other phrases if a response has been returned
     */
    public function doesNotCallOtherPhrasesIfResponseHasBeenReturned()
    {
        $response = $this->getMockForAbstractClass('Zend\Stdlib\ResponseInterface');

        $responsePhrase = $this->getPhraseMock();
        $responsePhrase->expects($this->any())
                       ->method('execute')
                       ->will($this->returnValue($response));

        $otherPhrase = $this->getPhraseMock();
        $otherPhrase->expects($this->never())
                    ->method('execute');

        $this->executor->addPhrase($responsePhrase);
        $this->executor->addPhrase($otherPhrase);
        $this->executor->execute($this->getContainerMock());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function assignsViewVariablesToTheViewModel()
    {
        $viewVariables = array('foo' => 'bar', 'bar' => 'baz', 'baz' => 'foo');

        $viewModel = $this->getMockForAbstractClass('Zend\View\Model\ModelInterface');
        $viewModel->expects($this->once())
                  ->method('setVariables')
                  ->with($viewVariables);

        $container = $this->getContainerMock();
        $container->expects($this->any())
                  ->method('getViewVariables')
                  ->will($this->returnValue($viewVariables));
        $container->expects($this->any())
                  ->method('getViewModel')
                  ->will($this->returnValue($viewModel));

        $this->executor->execute($container);
    }
}

