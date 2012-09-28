<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Exception
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl\Exception;

use PHPUnit_Framework_TestCase as TestCase;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Exception
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class ResultLockedTest extends TestCase
{

    /**
     * @test
     * @group Component/Dsl/Exception
     * @group Module/DkplusControllerDsl
     */
    public function isAnException()
    {
        $this->assertInstanceOf('Exception', new ResultLocked('view model'));
    }

    /**
     * @test
     * @group Component/Dsl/Exception
     * @group Module/DkplusControllerDsl
     */
    public function isAnDslException()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Exception\ExceptionInterface', new ResultLocked('response'));
    }

    /**
     * @test
     * @group Component/Dsl/Exception
     * @group Module/DkplusControllerDsl
     */
    public function containsVariableNameInErrorMessage()
    {
        $exception = new ResultLocked('view model');
        $this->assertContains('view model', $exception->getMessage());
    }

    /**
     * @test
     * @group Component/Dsl/Exception
     * @group Module/DkplusControllerDsl
     */
    public function providesReadableMessages()
    {
        $exception = new ResultLocked('response');
        $this->assertStringStartsNotWith('response', $exception->getMessage());
        $this->assertStringEndsNotWith('response', $exception->getMessage());
    }
}
