<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl\Phrase;

use DkplusControllerDsl\Dsl\ContainerInterface as Container;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class DisableLayout implements ModifiablePhraseInterface
{
    /** @var boolean */
    private $onAjaxOnly = false;

    public function setOptions(array $options)
    {
        if (\array_key_exists('onAjax', $options)) {
            $this->onAjaxOnly = true;
        }
    }

    public function execute(Container $container)
    {
        if ($container->getRequest()->isXmlHttpRequest()
            || !$this->onAjaxOnly
        ) {
            $container->lockViewModel();
            $container->getViewModel()->terminate();
        }
    }
}

