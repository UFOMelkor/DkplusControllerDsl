<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl\Executor;

use DkplusControllerDsl\Dsl\Phrase\PhraseInterface as Phrase;
use DkplusControllerDsl\Dsl\ContainerInterface as Container;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 */
interface ExecutorInterface
{
    /** @param Phrase $phrase */
    public function addPhrase(Phrase $phrase);

    /**
     * @param Container $container
     * @return \Zend\View\Model\ModelInterface|\Zend\Stdlib\ResponseInterface
     */
    public function execute(Container $container);
}
