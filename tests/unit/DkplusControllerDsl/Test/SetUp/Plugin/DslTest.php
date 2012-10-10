<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Test\SetUp\Plugin
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Test\SetUp\Plugin;

use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Test\SetUp\Plugin
 * @author     Oskar Bley <oskar@programming-php.net>
 * @covers     DkplusControllerDsl\Test\SetUp\Plugin\Dsl
 */
class DslTest extends TestCase
{
    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox is a plugin setup
     */
    public function isPluginSetUp()
    {
        $this->assertInstanceOf('DkplusUnitTest\Controller\SetUp\Plugin\AbstractPlugin', new Dsl($this));
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     */
    public function nameIsDsl()
    {
        $pluginSetUp = new Dsl($this);
        $this->assertSame('dsl', $pluginSetUp->getName());
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     */
    public function createsPluginMock()
    {
        $dslMock     = $this->getMock('DkplusControllerDsl\Dsl\Test\SetUp\Plugin\Dsl');
        $mockBuilder = $this->getMockBuilderStubThatCreates($dslMock);
        $testCase    = $this->getMockBuilder('DkplusControllerDsl\Test\TestCase')
                            ->disableOriginalConstructor()
                            ->getMock();
        $testCase->expects($this->once())
                 ->method('getMockBuilder')
                 ->with('DkplusControllerDsl\Controller\Plugin\Dsl')
                 ->will($this->returnValue($mockBuilder));
        $this->stubMockingWithMockBuilder($testCase, $mockBuilder);

        $pluginSetUp = new Dsl($testCase);
        $this->assertSame($dslMock, $pluginSetUp->createMock());
    }

    /**
     * @param MockObject $dslMock
     * @return MockObject|\PHPUnit_Framework_MockObject_MockBuilder
     */
    private function getMockBuilderStubThatCreates(MockObject $dslMock)
    {
        $mockBuilder = $this->getMockBuilder('PHPUnit_Framework_MockObject_MockBuilder')
                            ->disableOriginalConstructor()
                            ->getMock();
        $mockBuilder->expects($this->any())
                    ->method('disableOriginalConstructor')
                    ->will($this->returnSelf());
        $mockBuilder->expects($this->any())
                    ->method('getMock')
                    ->will($this->returnValue($dslMock));
        return $mockBuilder;
    }

    private function stubMockingWithMockBuilder(TestCase $testCase, MockObject $mockBuilder)
    {
        $invocation = $this->getMockForAbstractClass('PHPUnit_Framework_MockObject_Matcher_Invocation');
        $testCase->expects($this->any())
                 ->method('getMockBuilder')
                 ->will($this->returnValue($mockBuilder));
        $testCase->staticExpects($this->any())
                 ->method('any')
                 ->will($this->returnValue($invocation));
        $testCase->staticExpects($this->any())
                 ->method('returnCallback')
                 ->will($this->returnValue($this->getMock('PHPUnit_Framework_MockObject_Stub')));
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     */
    public function createsDslMocksOnDemand()
    {
        $pluginSetUp = new Dsl($this);

        $dsl = $pluginSetUp->getNextDsl();
        $this->assertNotSame($dsl, $pluginSetUp->getNextDsl());
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     */
    public function canReturnRegisteredDslMocks()
    {
        $dsl = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\DslInterface');

        $pluginSetUp = new Dsl($this);
        $pluginSetUp->addDsl($dsl);

        $this->assertSame($dsl, $pluginSetUp->getNextDsl());
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     */
    public function canRegisterDslMocksAtSpecificPositions()
    {
        $dsl = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\DslInterface');

        $pluginSetUp = new Dsl($this);
        $pluginSetUp->addDsl($dsl, 1);

        $this->assertNotSame($dsl, $pluginSetUp->getNextDsl());
        $this->assertSame($dsl, $pluginSetUp->getNextDsl());
    }
}
