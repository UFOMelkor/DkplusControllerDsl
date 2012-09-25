<?php
/**
 * @codeCoverageIgnore
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl\Phrase;

use DkplusControllerDsl\Dsl\ContainerInterface as Container;

/**
 * @codeCoverageIgnore
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */
interface ExecutablePhraseInterface extends PhraseInterface
{
    /**
     * @param Container $container
     * @return array|\Zend\View\Model\ModelInterface|\Zend\Stdlib\ResponseInterface An array of sub-phrases or a result.
     */
    public function execute(Container $container);
}

