<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Test
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Test;

use DkplusUnitTest\Controller\StandardTestCase as BaseTestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Test
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class TestCase extends BaseTestCase
{
    /** @var SetUp\Plugin\Dsl */
    private $dslPlugin;

    protected function initSetUp()
    {
        parent::initSetUp();

        $this->dslPlugin = new SetUp\Plugin\Dsl($this);
        $this->addPlugin($this->dslPlugin);
    }

    /** @return DslMockBuilder */
    public function getDslMockBuilder()
    {
        return new DslMockBuilder($this);
    }

    /**
     * Used by the mock builder.
     *
     * @param MockObject $dsl
     * @param int $position
     */
    public function registerDsl(MockObject $dsl, $position)
    {
        $this->dslPlugin->addDsl($dsl, $position);
    }

    public function assertDsl($result)
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\DslInterface', $result);
    }

    /** @return DslExpectations */
    public function expectsDsl()
    {
        return new DslExpectations($this);
    }

    /** @return DslExpectations */
    public function expectsDslNumber($number)
    {
        return new DslExpectations($this, $number);
    }
}
