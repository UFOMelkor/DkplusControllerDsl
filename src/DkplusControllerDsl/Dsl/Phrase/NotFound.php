<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl\Phrase;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class NotFound extends ResponseCode implements PrePhraseInterface
{
    public function __construct()
    {
        parent::__construct(array(404));
    }

    /** @return array */
    public function getOptions()
    {
        return array('type' => '404-not-found');
    }
}
