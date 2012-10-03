<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Test
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Test;


/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Test
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class DslExpectations
{
    /** @var int|null */
    protected $position;

    /** @var TestCase */
    protected $testCase;

    public function __construct(TestCase $testCase, $position = null)
    {
        $this->position = $position;
        $this->testCase = $testCase;
    }

    /** @return \DkplusControllerDsl\Dsl\DslInterface|\PHPUnit_Framework_MockObject_MockObject */
    public function toRedirectToRoute($route)
    {
        $mock = $this->getMockWithPhrases(array('redirect', 'route'));
        $mock->expects($this->testCase->atLeastOnce())
             ->method('redirect')
             ->will($this->testCase->returnSelf());
        $mock->expects($this->testCase->atLeastOnce())
             ->method('route')
             ->with($route)
             ->will($this->testCase->returnSelf());
        return $mock;
    }

    /** @return \DkplusControllerDsl\Dsl\DslInterface|\PHPUnit_Framework_MockObject_MockObject */
    public function toRedirectToUrl($url)
    {
        $mock = $this->getMockWithPhrases(array('redirect', 'url'));
        $mock->expects($this->testCase->atLeastOnce())
             ->method('redirect')
             ->will($this->testCase->returnSelf());
        $mock->expects($this->testCase->atLeastOnce())
             ->method('url')
             ->with($url)
             ->will($this->testCase->returnSelf());
        return $mock;
    }

    /** @return \DkplusControllerDsl\Dsl\DslInterface|\PHPUnit_Framework_MockObject_MockObject */
    public function toAddFlashMessage($message = null, $namespace = null)
    {
        $mock = $namespace == null
              ? $this->getMockWithPhrases(array('message'))
              : $this->getMockWithPhrases(array('message', $namespace));

        if ($namespace !== null) {
            $mock->expects($this->testCase->atLeastOnce())
                 ->method($namespace)
                 ->will($this->testCase->returnSelf());
        }

        if ($message === null) {
            $mock->expects($this->testCase->atLeastOnce())
                 ->method('message')
                 ->will($this->testCase->returnSelf());
        } else {
            $mock->expects($this->testCase->atLeastOnce())
                 ->method('message')
                 ->with($message)
                 ->will($this->testCase->returnSelf());
        }
        return $mock;
    }

    /** @return \DkplusControllerDsl\Dsl\DslInterface|\PHPUnit_Framework_MockObject_MockObject */
    public function toDisableLayout()
    {
        $mock = $this->getMockWithPhrases(array('disableLayout'));
        $mock->expects($this->testCase->once())
             ->method('disableLayout')
             ->will($this->testCase->returnSelf());
        return $mock;
    }

    /** @return \DkplusControllerDsl\Dsl\DslInterface|\PHPUnit_Framework_MockObject_MockObject */
    public function toReturnJson()
    {
        $mock = $this->getMockWithPhrases(array('asJson'));
        $mock->expects($this->testCase->once())
             ->method('asJson')
             ->will($this->testCase->returnSelf());
        return $mock;
    }

    /** @return \DkplusControllerDsl\Dsl\DslInterface|\PHPUnit_Framework_MockObject_MockObject */
    public function toAssign($variable, $key = null)
    {
        $mock = $this->getMockWithPhrases(array('assign'));
        $mock->expects($this->testCase->atLeastOnce())
             ->method('assign')
             ->with($variable)
             ->will($this->testCase->returnSelf());

        if ($key === null) {
            return $mock;
        }

        $mock->expects($this->testCase->atLeastOnce())
             ->method('__call')
             ->with('as', array($key))
             ->will($this->testCase->returnSelf());
        return $mock;
    }

    /** @return \DkplusControllerDsl\Dsl\DslInterface|\PHPUnit_Framework_MockObject_MockObject */
    private function getMockWithPhrases(array $phrases)
    {
        return $this->testCase->getDslMockBuilder()
                              ->usedAt($this->position)
                              ->withMockedPhrases($phrases)
                              ->getMock();
    }
}
