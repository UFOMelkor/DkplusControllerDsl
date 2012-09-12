<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl;

/**
 * @category   DkplusControllerDsl
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 */
interface DslInterface
{
    /** @return \Zend\Stdlib\ResponseInterface|\Zend\View\Model\ModelInterface */
    public function execute(ContainerInterface $container);
}

