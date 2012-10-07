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

    /** @var mixed */
    private $parameters;

    public function __construct(array $options)
    {
        if (isset($options[0])) {
            $this->route = $options[0];
        }
        if (isset($options[1])) {
            $this->parameters = $options[1];
        }
    }

    /** @return array */
    public function getOptions()
    {
        $result = array('route' => $this->route);
        if ($this->parameters !== null) {
            $result['with'] = $this->parameters;
        }
        return $result;
    }
}
