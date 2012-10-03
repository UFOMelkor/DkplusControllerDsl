<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl\Phrase;

use DkplusControllerDsl\Dsl\ContainerInterface as Container;
use DkplusControllerDsl\Dsl\DslInterface as Dsl;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class OnAjaxRequest implements ExecutablePhraseInterface
{
    /** @var Dsl */
    private $ajaxHandler;

    public function __construct(array $options)
    {
        if (isset($options[0])) {
            $this->ajaxHandler = $options[0];
        }
    }

    public function execute(Container $container)
    {
        if ($container->getRequest()->isXmlHttpRequest()) {

            if (\is_callable($this->ajaxHandler)) {
                $this->ajaxHandler = \call_user_func($this->ajaxHandler);
            }
            $this->ajaxHandler->execute($container);
        }
    }
}
