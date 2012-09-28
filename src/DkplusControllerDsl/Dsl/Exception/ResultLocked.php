<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Exception
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl\Exception;

use \BadMethodCallException;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Exception
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class ResultLocked extends BadMethodCallException implements ExceptionInterface
{
    public function __construct($resultType)
    {
        parent::__construct("Sorry, but the $resultType has been locked");
    }
}
