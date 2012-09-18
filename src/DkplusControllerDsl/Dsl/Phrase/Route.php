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
class Route implements PostPhraseInterface
{
    /** @var string */
    private $route;

    public function __construct(array $options)
    {
        if (isset($options[0])) {
            $this->route = $options[0];
        }
    }

    /** @return array */
    public function getOptions()
    {
        return array('route' => $this->route);
    }
}

