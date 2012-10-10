<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Test
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Test;

use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as BaseTestCase;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Test
 * @author     Oskar Bley <oskar@programming-php.net>
 * @covers     DkplusControllerDsl\Test\DslMockBuilder
 */
class DslMockBuilderTest extends BaseTestCase
{
    /** @var TestCase|\PHPUnit_Framework_MockObject_MockObject */
    private $testCase;

    /** @var DslMockBuilder */
    private $mockBuilder;

    protected function setUp()
    {
        $this->testCase = $this->getMockBuilder('DkplusControllerDsl\Test\TestCase')
                               ->disableOriginalConstructor()
                               ->getMock();

        $this->mockBuilder = new DslMockBuilder($this->testCase);
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox is a mock builder
     */
    public function isMockBuilder()
    {
        $this->assertInstanceOf('PHPUnit_Framework_MockObject_MockBuilder', $this->mockBuilder);
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     */
    public function createsDslMocks()
    {
        $dslMock = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\DslInterface');
        $this->stubMockingWithMockResult($dslMock);

        $this->assertSame($dslMock, $this->mockBuilder->getMockForAbstractClass());
    }

    private function stubMockingWithMockResult(MockObject $dslMock)
    {
        $invocation = $this->getMockForAbstractClass('PHPUnit_Framework_MockObject_Matcher_Invocation');
        $this->testCase->expects($this->any())
                       ->method('getMock')
                       ->will($this->returnValue($dslMock));
        $this->testCase->staticExpects($this->any())
                       ->method('any')
                       ->will($this->returnValue($invocation));
        $this->testCase->staticExpects($this->any())
                       ->method('returnSelf')
                       ->will($this->returnValue($this->getMock('PHPUnit_Framework_MockObject_Stub')));
        $this->testCase->expects($this->any())
                       ->method('expects')
                       ->will($this->returnSelf());
        $this->testCase->expects($this->any())
                       ->method('method')
                       ->will($this->returnSelf());
        $this->testCase->expects($this->any())
                       ->method('will')
                       ->will($this->returnSelf());
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     */
    public function registersDslWhenCreating()
    {
        $dslMock = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\DslInterface');
        $this->stubMockingWithMockResult($dslMock);

        $this->testCase->expects($this->once())
                       ->method('registerDsl')
                       ->with($dslMock);
        $this->mockBuilder->getMock();
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     */
    public function registersDslAtPositionNullOnDefault()
    {
        $dslMock = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\DslInterface');
        $this->stubMockingWithMockResult($dslMock);

        $this->testCase->expects($this->once())
                       ->method('registerDsl')
                       ->with($this->anything(), $this->isNull());
        $this->mockBuilder->getMock();
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox can register a dsl at a specific position
     */
    public function canRegisterDslAtSpecificPosition()
    {
        $dslMock = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\DslInterface');
        $this->stubMockingWithMockResult($dslMock);

        $this->testCase->expects($this->once())
                       ->method('registerDsl')
                       ->with($this->anything(), 3);
        $this->mockBuilder->usedAt(3);
        $this->mockBuilder->getMock();
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     */
    public function mocksCallAndExecuteMethodsOfDsl()
    {
        $dslMock = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\DslInterface');

        $this->testCase->expects($this->once())
                       ->method('getMock')
                       ->with($this->anything(), array('__call', 'execute'))
                       ->will($this->returnValue($dslMock));
        $this->stubMockingWithMockResult($dslMock);

        $this->mockBuilder->getMock();
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     */
    public function canMockAdditionalMethods()
    {
        $dslMock = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\DslInterface');

        $this->testCase->expects($this->once())
                       ->method('getMock')
                       ->with($this->anything(), array('__call', 'execute', 'foo', 'bar'))
                       ->will($this->returnValue($dslMock));
        $this->stubMockingWithMockResult($dslMock);

        $this->mockBuilder->withMockedPhrases(array('foo', 'bar'));
        $this->mockBuilder->getMock();
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox provides a fluent interface
     * @dataProvider provideMethodsWithFluentInterfaceSupport
     * @param string $method
     * @param array $arguments
     */
    public function providesFluentInterface($method, array $arguments)
    {
        $this->assertSame($this->mockBuilder, \call_user_func_array(array($this->mockBuilder, $method), $arguments));
    }

    public static function provideMethodsWithFluentInterfaceSupport()
    {
        return array(
            array('withMockedPhrases', array(array())),
            array('setMethods', array(array())),
            array('usedAt', array(5))
        );
    }
}
