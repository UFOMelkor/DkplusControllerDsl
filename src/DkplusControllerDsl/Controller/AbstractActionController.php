<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Controller
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Controller;

use DkplusControllerDsl\Dsl\DslInterface as Dsl;
use Zend\Mvc\Controller\AbstractActionController as BaseController;
use Zend\Mvc\MvcEvent;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Controller
 * @author     Oskar Bley <oskar@programming-php.net>
 */
abstract class AbstractActionController extends BaseController
{
    public function onDispatch(MvcEvent $event)
    {
        $parentResult = parent::onDispatch($event);

        if (!$parentResult instanceof Dsl) {
            return $parentResult;
        }

        $result = $parentResult->execute();
        $event->setResult($result);
        return $result;
    }
}

