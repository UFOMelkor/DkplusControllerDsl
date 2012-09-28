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
class Into implements PostPhraseInterface
{
    /** @var callable */
    private $target;

    public function __construct(array $options)
    {
        if (isset($options[0])) {
            $this->target = $options[0];
        }
    }

    /** @return array */
    public function getOptions()
    {
        return array('target' => $this->target);
    }
}
