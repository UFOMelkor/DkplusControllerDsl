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
class AssignFormMessages extends Assign
{
    /** @var mixed */
    private $form;

    public function __construct(array $options)
    {
        if (isset($options[0])) {
            $this->form = $options[0];
        }
    }

    /** @return mixed */
    public function getVariable()
    {
        if ($this->form instanceof FormInterface) {
            return $this->form->getMessages();
        }
    }

    public function execute(Container $container)
    {
        if ($this->getVariable() == null) {
            $this->form = $container->getVariable('form');
        }
        return parent::execute($container);
    }
}

