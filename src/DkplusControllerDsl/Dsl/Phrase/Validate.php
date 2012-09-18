<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl\Phrase;

use DkplusControllerDsl\Dsl\ContainerInterface as Container;
use DkplusControllerDsl\Dsl\DslInterface as Dsl;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class Validate implements ModifiablePhraseInterface
{
    /** @var \Zend\Form\FormInterface */
    private $form;

    /** @var array */
    private $validationData;

    /** @var Dsl */
    private $ajaxHandler;

    /** @var Dsl */
    private $successHandler;

    /** @var Dsl */
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

    /** @return \Zend\Form\FormInterface */
    public function getForm()
    {
        return $this->form;
    }

    /** @return array */
    public function getValidateAgainst()
    {
        return $this->validationData;
    }

    /** @return Dsl */
    public function getAjaxHandler()
    {
        return $this->ajaxHandler;
    }

    /** @return Dsl */
    public function getSuccessHandler()
    {
        return $this->successHandler;
    }

    /** @return Dsl */
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

        if ($container->getRequest()->isXmlHttpRequest()) {
            if ($this->ajaxHandler instanceof Dsl) {
                $this->ajaxHandler->execute($container);
            }
        } elseif ($form->isValid()) {
            if ($this->successHandler instanceof Dsl) {
                $this->successHandler->execute($container);
            }
        } elseif ($this->failureHandler instanceof Dsl) {
            $this->failureHandler->execute($container);
        }
    }
}

