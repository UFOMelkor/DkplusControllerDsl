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
class ControllerAction extends OptionProvider implements PostPhraseInterface
{
    public function __construct(array $options)
    {
        $options[1] = array('action' => $options[1]);
        if (isset($options[2])) {
            $options[1] = \array_merge($options[1], $options[2]);
            unset($options[2]);
        }
        parent::__construct(array('controller', 'route_params'), $options);
    }
}
