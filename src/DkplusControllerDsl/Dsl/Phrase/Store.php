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
    /** @var mixed */
    private $data;

    /** @var array */
    private $additionalData = array();

    /** @var callable */
    private $target;

    public function __construct(array $options)
    {
        if (isset($options[0])) {
            $this->data = $options[0];
        }
    }

    /** @return mixed */
    public function getData()
    {
        if (\is_callable($this->data)) {
            return \call_user_func($this->data);
        }
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

        if (isset($options['with'])) {
            $this->additionalData = $options['with'];
        }
    }

    public function execute(Container $container)
    {

        $target = $this->getTarget();

        $data = $this->additionalData;
        \array_unshift($data, $this->getData());

        \call_user_func_array($target, $data);
    }
}
