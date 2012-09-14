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
class ValidateForm implements ModifiablePhraseInterface
{
    /** @var \Zend\Form\Form */
    private $form;

    /** @var array */
    private $validationData;

    /** @var ExecutablePhraseInterface */
    private $ajaxHandler;

    /** @var ExecutablePhraseInterface */
    private $successHandler;

    /** @var ExecutablePhraseInterface */
    private $failureHandler;

    public function __construct(array $options)
    {
        if (isset($options[0])) {
            $this->form = $options[0];
        }

        if (isset($options[1])) {
            $this->validationData = (array) $options[1];
        }
    }

    /** @return \Zend\Form\Form */
    public function getForm()
    {
        return $this->form;
    }

    /** @return array */
    public function getValidateAgainst()
    {
        return $this->validationData;
    }

    /** @return ExecutableInterface */
    public function getAjaxHandler()
    {
        return $this->ajaxHandler;
    }

    /** @return ExecutableInterface */
    public function getSuccessHandler()
    {
        return $this->successHandler;
    }

    /** @return ExecutableInterface */
    public function getFailureHandler()
    {
        return $this->failureHandler;
    }

    public function setOptions(array $options)
    {
        if (isset($options['against'])) {
            $this->validationData = $options['against'];
        }

        if (isset($options['onAjax'])) {
            $this->ajaxHandler = $options['onAjax'];
        }

        if (isset($options['onSuccess'])) {
            $this->successHandler = $options['onSuccess'];
        }

        if (isset($options['onFailure'])) {
            $this->failureHandler = $options['onFailure'];
        }
    }

    public function execute(Container $container)
    {
        $form = $this->getForm();

        if ($form == null) {
            $form = $container->getVariable('form');
        }

        $form->setData($this->getValidateAgainst());
        if ($form->isValid()) {

        }
    }
}

