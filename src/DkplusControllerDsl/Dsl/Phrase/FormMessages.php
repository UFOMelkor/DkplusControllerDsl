<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl\Phrase;

use DkplusControllerDsl\Dsl\ContainerInterface as Container;
use Zend\Form\FormInterface;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class FormMessages implements ContainerAwarePhraseInterface, PostPhraseInterface
{
    /** @var \Zend\Form\FormInterface|string */
    private $form;

    /** @var Container */
    private $container;

    public function __construct(array $options = array())
    {
        $this->form = isset($options[0])
                    ? $options[0]
                    : 'form';
    }

    public function getOptions()
    {
        $form = \is_string($this->form)
              ? $this->container->getVariable($this->form)
              : $this->form;

        return array('variable' => $form->getMessages());
    }

    public function setContainer(Container $container)
    {
        $this->container = $container;
    }
}
