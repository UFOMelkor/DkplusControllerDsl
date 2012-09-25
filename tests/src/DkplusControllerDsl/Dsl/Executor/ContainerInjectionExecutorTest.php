<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl\Executor;

use PHPUnit_Framework_TestCase as TestCase;

require_once __DIR__ . '/__assets/PostAndModifiableInterface.php';
require_once __DIR__ . '/__assets/PreAndModifiableInterface.php';

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class ContainerInjectionExecutorTest extends TestCase
{
    /** @var ExecutorInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $decorated;

    /** @var ContainerInjectionExecutor */
    private $executor;

    protected function setUp()
    {
        $this->decorated = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Executor\ExecutorInterface');
        $this->executor  = new ContainerInjectionExecutor($this->decorated);
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
    public function doesNotAddPhrasesDirectlyToDecoratedExecutor()
    {
        $phrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\PhraseInterface');
        $this->decorated->expects($this->never())
                        ->method('addPhrase');
        $this->executor->addPhrase($phrase);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function injectsContainerIntoContainerAwarePhrases()
    {
        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');

        $phrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\ContainerAwarePhraseInterface');
        $phrase->expects($this->once())
               ->method('setContainer')
               ->with($container);

        $this->executor->addPhrase($phrase);
        $this->executor->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function refersPhrasesToDecoratedExecutorOnExecution()
    {
        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $phrase    = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\ContainerAwarePhraseInterface');
        $this->executor->addPhrase($phrase);

        $this->decorated->expects($this->once())
                        ->method('addPhrase')
                        ->with($phrase);
        $this->executor->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function executesDecoratedExecutor()
    {
        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');

        $this->decorated->expects($this->once())
                        ->method('execute')
                        ->with($container);
        $this->executor->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function returnsExecutionResult()
    {
        $response  = $this->getMockForAbstractClass('Zend\Stdlib\ResponseInterface');
        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');

        $this->decorated->expects($this->any())
                        ->method('execute')
                        ->will($this->returnValue($response));

        $this->assertSame($response, $this->executor->execute($container));
    }
}

