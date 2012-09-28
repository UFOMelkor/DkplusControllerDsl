<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl\Phrase;

use DkplusControllerDsl\Dsl\DslInterface as Dsl;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class OnSuccess implements PostPhraseInterface
{
    /** @var Dsl */
    private $successHandler;

    public function __construct(array $options)
    {
        if (isset($options[0])) {
            $this->successHandler = $options[0];
        }
    }

    /** @return array */
    public function getOptions()
    {
        return array('onSuccess' => $this->successHandler);
    }
}
