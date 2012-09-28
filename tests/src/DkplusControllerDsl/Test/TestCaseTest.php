<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Test
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Test;

use PHPUnit_Framework_TestCase as BaseTestCase;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Test
 * @author     Oskar Bley <oskar@programming-php.net>
 * @covers     DkplusControllerDsl\Test\TestCase
 */
class TestCaseTest extends BaseTestCase
{
    /** @var TestCase */
    private $testCase;

    protected function setUp()
    {
        $this->testCase = new TestCase();
    }

    /**
     * @test
     * @group Module/DkplusControllerDsl
     * @group Component/Test
     */
    public function canBeUsedAsPhpUnitTestCase()
    {
        $this->assertInstanceOf('PHPUnit_Framework_TestCase', $this->testCase);
    }

    /**
     * @test
     * @group Module/DkplusControllerDsl
     * @group Component/Test
     */
    public function providesDslMockBuilders()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Test\DslMockBuilder', $this->testCase->getDslMockBuilder());
    }

    /**
     * @test
     * @group Module/DkplusControllerDsl
     * @group Component/Test
     */
    public function providesDslAssertionThatMatchesDsls()
    {
        $this->testCase->assertDsl($this->getMockForAbstractClass('DkplusControllerDsl\Dsl\DslInterface'));
    }

    /**
     * @test
     * @group Module/DkplusControllerDsl
     * @group Component/Test
     */
    public function providesDslAssertionThatOnlyMatchesDsls()
    {
        try {
            $this->testCase->assertDsl(true);
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            return;
        }
        $this->fail('Assertion should not match true');
    }

    /**
     * @test
     * @group Module/DkplusControllerDsl
     * @group Component/Test
     */
    public function providesDslExpectations()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Test\DslExpectations', $this->testCase->expectsDsl());
    }

    /**
     * @test
     * @group Module/DkplusControllerDsl
     * @group Component/Test
     */
    public function providesDslExpectationsForDslsAtSpecificPositions()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Test\DslExpectations', $this->testCase->expectsDslNumber(5));
    }
}
