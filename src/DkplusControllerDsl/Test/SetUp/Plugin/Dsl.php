<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Test\SetUp\Plugin
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Test\SetUp\Plugin;

use DkplusUnitTest\Controller\SetUp\Plugin\AbstractPlugin;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Test\SetUp\Plugin
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class Dsl extends AbstractPlugin
{
    /** @var \DkplusControllerDsl\Controller\Plugin\Dsl|MockObject */
    private $mock;

    private $dslMap = array();

    /** @var int */
    private $creationCounter = 0;

    public function createMock()
    {
        $this->creationCounter = 0;
        $this->getCounter      = 0;
        $this->dslMap          = array();

        $this->mock = $this->testCase->getMockBuilder('DkplusControllerDsl\Controller\Plugin\Dsl')
                                     ->disableOriginalConstructor()
                                     ->getMock();
        $this->mock->expects($this->testCase->any())
                   ->method('__invoke')
                   ->will($this->testCase->returnCallback(array($this, 'getNextDsl')));

        return $this->mock;
    }

    public function getName()
    {
        return 'dsl';
    }

    public function addDsl(MockObject $dsl, $position = null)
    {
        if ($position == null) {
            $position = $this->creationCounter++;
        }

        $this->dslMap[$position] = $dsl;
    }

    /** @return \DkplusControllerDsl\Dsl\DslInterface|MockObject */
    public function getNextDsl()
    {
        if (isset($this->dslMap[$this->getCounter])) {
            return $this->dslMap[$this->getCounter++];
        }

        ++$this->getCounter;

        $mock = $this->testCase->getMockForAbstractClass('DkplusControllerDsl\Dsl\DslInterface');
        $mock->expects($this->testCase->any())
             ->method('__call')
             ->will($this->testCase->returnSelf());
        $mock->expects($this->testCase->any())
             ->method('execute')
             ->will($this->testCase->returnSelf());
        return $mock;
    }
}

