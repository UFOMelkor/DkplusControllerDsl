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
class Store implements ModifiablePhraseInterface
{
    /** @var array */
    private $data;

    /** @var callable */
    private $target;

    public function __construct(array $options)
    {
        if (isset($options[0])) {
            $this->data = $options[0];
        }
    }

    /** @return array */
    public function getData()
    {
        return $this->data;
    }

    /** @return callable */
    public function getTarget()
    {
        return $this->target;
    }

    public function setOptions(array $options)
    {
        if (isset($options['data'])) {
            $this->data = $options['data'];
        }
        if (isset($options['target'])) {
            $this->target = $options['target'];
        }
    }

    public function execute(Container $container)
    {
        $data   = $this->getData();
        $target = $this->getTarget();

        if (\is_callable($data)) {
            $data = \call_user_func($data);
        }

        \call_user_func($target, $data);
    }
}
