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
class DslTest extends TestCase
{
    /** @var ExecutorInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $executor;

    /** @var \Zend\ServiceManager\AbstractPluginManager|\PHPUnit_Framework_MockObject_MockObject */
    private $pluginManager;

    /** @var \Zend\Mvc\Controller\AbstractController|\PHPUnit_Framework_MockObject_MockObject */
    private $controller;

    /** @var Dsl */
    private $dsl;

    protected function setUp()
    {
        $this->executor      = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ExecutorInterface');
        $this->pluginManager = $this->getMockBuilder('Zend\ServiceManager\AbstractPluginManager')
                                    ->setMethods(array('get', 'validatePlugin'))
                                    ->getMock();
        $this->controller    = $this->getMock('Zend\Mvc\Controller\AbstractController');
        $this->dsl           = new Dsl($this->pluginManager, $this->executor, $this->controller);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @testdox is a dsl
     */
    public function isDsl()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\DslInterface', $this->dsl);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @testdox has a plugin manager
     */
    public function hasPluginManager()
    {
        $this->assertSame($this->pluginManager, $this->dsl->getPluginManager());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @testdox has a executor
     */
    public function hasExecutor()
    {
        $this->assertSame($this->executor, $this->dsl->getExecutor());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function usesTheExecuterToExecute()
    {
        $executionResult = $this->getMockForAbstractClass('Zend\View\Model\ModelInterface');
        $container       = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');

        $this->executor->expects($this->once())
                       ->method('execute')
                       ->with($container)
                       ->will($this->returnValue($executionResult));

        $this->assertSame($executionResult, $this->dsl->execute($container));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function fetchesPhrasesFromThePluginManager()
    {
        $phrase     = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\PhraseInterface');
        $phraseName = 'phraseAbc';
        $this->pluginManager->expects($this->once())
                            ->method('get')
                            ->with($phraseName)
                            ->will($this->returnValue($phrase));
        $this->dsl->{$phraseName}();
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @testdox passes arguments as options to the plugin manager when fetching a phrase
     */
    public function passesArgumentsAsOptionsToThePluginManagerWhenFetchingPhrase()
    {
        $phrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\PhraseInterface');
        $this->pluginManager->expects($this->once())
                            ->method('get')
                            ->with($this->anything(), array('foo', 'bar', 'baz'))
                            ->will($this->returnValue($phrase));
        $this->dsl->phraseAbc('foo', 'bar', 'baz');
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function addsFetchedPhraseToTheExecutor()
    {
        $phrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\PhraseInterface');
        $this->pluginManager->expects($this->once())
                            ->method('get')
                            ->will($this->returnValue($phrase));
        $this->executor->expects($this->once())
                       ->method('addPhrase')
                       ->with($phrase);
        $this->dsl->phraseAbc();
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @testdox provides a fluent interface
     */
    public function providesFluentInterface()
    {
        $phrase = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\Phrase\PhraseInterface');
        $this->pluginManager->expects($this->once())
                            ->method('get')
                            ->will($this->returnValue($phrase));
        $this->assertSame($this->dsl, $this->dsl->phraseAbc());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function createsStandardContainerIfNoContainerIsGiven()
    {
        $this->executor->expects($this->once())
                       ->method('execute')
                       ->with($this->isInstanceOf('DkplusControllerDsl\Dsl\Container'));
        $this->dsl->execute();
    }
}

