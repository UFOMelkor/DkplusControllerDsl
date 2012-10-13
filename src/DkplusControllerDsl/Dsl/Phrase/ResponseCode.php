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
class ResponseCode implements ExecutablePhraseInterface
{
    /** @var int */
    private $responseCode;

    public function __construct(array $options)
    {
        $this->responseCode = $options[0];
    }

    public function execute(Container $container)
    {
        $container->getResponse()->setStatusCode($this->responseCode);
    }
}
