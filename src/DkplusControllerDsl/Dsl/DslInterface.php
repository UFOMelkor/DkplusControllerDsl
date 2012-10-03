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
 * @method DslInterface against() against(mixed $data)
 * @method DslInterface and() and()
 * @method DslInterface as() as(string $alias)
 * @method DslInterface asJson() asJson()
 * @method DslInterface assign() assign(mixed $variable[, string $alias])
 */
interface DslInterface
{
    /** @return \Zend\Stdlib\ResponseInterface|\Zend\View\Model\ModelInterface */
    public function execute(ContainerInterface $container = null);

    public function __call($method, $arguments);
}
