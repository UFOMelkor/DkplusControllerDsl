<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Exception
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl\Exception;

use \InvalidArgumentException;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Exception
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class VariableNotFound extends InvalidArgumentException implements ExceptionInterface
{
    public function __construct($variableName)
    {
        parent::__construct("There is no variable '$variableName'");
    }
}
