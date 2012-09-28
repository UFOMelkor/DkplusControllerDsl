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
class VariableNotFoundTest extends TestCase
{

    /**
     * @test
     * @group Component/Dsl/Exception
     * @group Module/DkplusControllerDsl
     */
    public function isAnException()
    {
        $this->assertInstanceOf('Exception', new VariableNotFound('foo'));
    }

    /**
     * @test
     * @group Component/Dsl/Exception
     * @group Module/DkplusControllerDsl
     */
    public function isAnDslException()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Exception\ExceptionInterface', new VariableNotFound('foo'));
    }

    /**
     * @test
     * @group Component/Dsl/Exception
     * @group Module/DkplusControllerDsl
     */
    public function containsVariableNameInErrorMessage()
    {
        $exception = new VariableNotFound('aLongVariableName');
        $this->assertContains('aLongVariableName', $exception->getMessage());
    }

    /**
     * @test
     * @group Component/Dsl/Exception
     * @group Module/DkplusControllerDsl
     */
    public function providesReadableMessages()
    {
        $exception = new VariableNotFound('aLongVariableName');
        $this->assertStringStartsNotWith('aLongVariableName', $exception->getMessage());
        $this->assertStringEndsNotWith('aLongVariableName', $exception->getMessage());
    }
}
