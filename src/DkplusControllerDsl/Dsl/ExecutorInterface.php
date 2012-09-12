<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 */
interface ExecutorInterface
{
    /** @param \DkplusControllerDsl\Dsl\Phrase\PhraseInterface $phrase */
    public function addPhrase(Phrase\PhraseInterface $phrase);

    /**
     * @param ContainerInterface $container
     * @return \Zend\View\Model\ModelInterface|\Zend\Stdlib\ResponseInterface
     */
    public function execute(ContainerInterface $container);
}

