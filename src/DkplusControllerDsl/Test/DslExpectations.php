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

    /** @var int */
    protected $starting = 0;

    public function __construct(TestCase $testCase, $position = null)
    {
        $this->position = $position;
        $this->testCase = $testCase;
    }

    public function startingFromPhraseNumber($number)
    {
        $this->starting = $number;
    }

    /** @return \DkplusControllerDsl\Dsl\DslInterface|\PHPUnit_Framework_MockObject_MockObject */
    public function toRedirectToRoute($route)
    {
        $mock = $this->getMockWithPhrases(array('redirect', 'route'));
        $mock->expects($this->testCase->once())
             ->method('redirect')
             ->will($this->testCase->returnSelf());
        $mock->expects($this->testCase->once())
             ->method('route')
             ->with($route)
             ->will($this->testCase->returnSelf());
        return $mock;
    }

    /** @return \DkplusControllerDsl\Dsl\DslInterface|\PHPUnit_Framework_MockObject_MockObject */
    public function toRedirectToUrl($url)
    {
        $mock = $this->getMockWithPhrases(array('redirect', 'url'));
        $mock->expects($this->testCase->once())
             ->method('redirect');
        $mock->expects($this->testCase->once())
             ->method('url')
             ->with($url)
             ->will($this->testCase->returnSelf());
        return $mock;
    }

    /** @return \DkplusControllerDsl\Dsl\DslInterface|\PHPUnit_Framework_MockObject_MockObject */
    public function toAddFlashMessage($message, $namespace = null)
    {
        $mock = $namespace == null
              ? $this->getMockWithPhrases(array('message'))
              : $this->getMockWithPhrases(array('message', $namespace));

        if ($namespace != null) {
            $mock->expects($this->testCase->once())
                 ->method($namespace)
                 ->will($this->testCase->returnSelf());
        }

        $mock->expects($this->testCase->once())
             ->method('message')
             ->with($message)
             ->will($this->testCase->returnSelf());
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
    public function toDisableLayoutOnAjax()
    {
        $mock = $this->getMockWithPhrases(array('disableLayout', 'onAjax'));
        $mock->expects($this->testCase->at($this->starting))
             ->method('disableLayout')
             ->will($this->testCase->returnSelf());
        $mock->expects($this->testCase->at($this->starting))
             ->method('onAjax')
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
    public function toAssignAs($variable, $key = null)
    {
        $mock = $this->getMockWithPhrases(array('assign'));
        $mock->expects($this->testCase->at($this->starting++))
             ->method('assign')
             ->with($variable)
             ->will($this->testCase->returnSelf());
        $mock->expects($this->testCase->at($this->starting++))
             ->method('__call')
             ->with('as', array($key))
             ->will($this->testCase->returnSelf());
        return $mock;
    }

    /** @return \DkplusControllerDsl\Dsl\DslInterface|\PHPUnit_Framework_MockObject_MockObject */
    public function toUseAndAssignAs($variable, $key = null)
    {
        $mock = $this->getMockWithPhrases(array('assign'));
        $mock->expects($this->testCase->at($this->starting++))
             ->method('__call')
             ->with('use', array($variable))
             ->will($this->testCase->returnSelf());
        $mock->expects($this->testCase->at($this->starting++))
             ->method('assign')
             ->will($this->testCase->returnSelf());
        $mock->expects($this->testCase->at($this->starting++))
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

