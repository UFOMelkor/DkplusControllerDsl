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
class Data implements PostPhraseInterface
{
    /** @var mixed */
    private $data;

    public function __construct(array $options)
    {
        if (isset($options[0])) {
            $this->data = $options[0];
        }
    }

    /** @return array */
    public function getOptions()
    {
        return array('data' => $this->data);
    }
}

