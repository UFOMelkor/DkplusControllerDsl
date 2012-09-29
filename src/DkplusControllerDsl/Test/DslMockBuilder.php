<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Test
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Test;

use PHPUnit_Framework_MockObject_MockBuilder as MockBuilder;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Test
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class DslMockBuilder extends MockBuilder
{
    /** @var int|null */
    protected $position = null;

    public function __construct(TestCase $testCase)
    {
        parent::__construct($testCase, 'DkplusControllerDsl\Dsl\DslInterface');
        $this->methods = array('__call', 'execute');
    }

    /**
     * @param array $methods
     * @return DslMockBuilder
     */
    public function withMockedPhrases(array $phrases)
    {
        return $this->setMethods($phrases);
    }

    /**
     * @param array $methods
     * @return DslMockBuilder
     */
    public function setMethods($methods)
    {
        $methods = \array_merge(array('__call', 'execute'), $methods);
        parent::setMethods($methods);
        return $this;
    }

    /**
     * @param int $position
     * @return DslMockBuilder
     */
    public function usedAt($position)
    {
        $this->position = $position;
        return $this;
    }

    /** @return \DkplusControllerDsl\Dsl\DslInterface|\PHPUnit_Framework_MockObject_MockObject */
    public function getMock()
    {
        $mock = parent::getMock();
        $mock->expects($this->testCase->any())
             ->method('__call')
             ->will($this->testCase->returnSelf());
        $mock->expects($this->testCase->any())
             ->method('execute')
             ->will($this->testCase->returnSelf());
        $this->testCase->registerDsl($mock, $this->position);
        return $mock;
    }

    /** @return \DkplusControllerDsl\Dsl\DslInterface|\PHPUnit_Framework_MockObject_MockObject */
    public function getMockForAbstractClass()
    {
        return $this->getMock();
    }
}
