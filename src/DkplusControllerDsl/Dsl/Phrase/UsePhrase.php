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
class UsePhrase implements ModifiablePhraseInterface
{
    /** @var mixed */
    private $variable;

    /** @var string */
    private $alias;

    public function __construct(array $options)
    {
        if (isset($options[0])) {
            $this->variable = $options[0];
        }

        if (isset($options[1])) {
            $this->alias = (string) $options[1];
        }
    }

    /** @return mixed */
    public function getVariable()
    {
        return $this->variable;
    }

    /** @return string */
    public function getAlias()
    {
        return $this->alias;
    }

    public function setOptions(array $options)
    {
        if (isset($options['alias'])) {
            $this->alias = $options['alias'];
        }
    }

    public function execute(Container $container)
    {
        $container->setVariable($this->alias, $this->variable);
    }
}

