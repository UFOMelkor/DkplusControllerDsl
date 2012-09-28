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
class WithPhrase implements PostPhraseInterface
{
    /** @var array */
    private $with;

    public function __construct(array $options)
    {
        $this->with = $options;
    }

    public function getOptions()
    {
        return array('with' => $this->with);
    }
}
