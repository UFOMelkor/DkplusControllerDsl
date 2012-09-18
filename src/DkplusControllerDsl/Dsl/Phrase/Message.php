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
class Message implements ModifiablePhraseInterface
{
    /** @var string */
    private $message;

    /** @var string */
    private $namespace = 'default';

    public function __construct(array $options)
    {
        if (isset($options[0])) {
            $this->message = $options[0];
        }
        if (isset($options[1])) {
            $this->namespace = $options[1];
        }
    }

    /** @return string */
    public function getMessage()
    {
        return $this->message;
    }

    /** @return string */
    public function getNamespace()
    {
        return $this->namespace;
    }

    public function setOptions(array $options)
    {
        if (isset($options['message'])) {
            $this->message = $options['message'];
        }

        if (isset($options['type'])) {
            $this->namespace = $options['type'];
        }
    }

    public function execute(Container $container)
    {
        $flashMessenger = $container->getController()->flashMessenger();
        $flashMessenger->setNamespace($this->getNamespace());
        $flashMessenger->addMessage($this->getMessage());
    }
}

