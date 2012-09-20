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
use Zend\Stdlib\ResponseInterface as Response;

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

    /** @var Container */
    private $container;

    public function __construct(array $options)
    {
        if (isset($options[0])) {
            $this->form = $options[0];
        }

        if (isset($options[1])) {
            $this->validationData = $options[1];
        }
    }

    /** @return \Zend\Form\FormInterface */
    public function getForm()
    {
        if ($this->form == null
            && $this->container != null
        ) {
            $this->form = $this->container->getVariable('form');
        }
        return $this->form;
    }

    /** @return array */
    public function getValidateAgainst()
    {
        if ($this->container == null) {
            return $this->validationData;
        }

        if (\is_string($this->validationData)
            && \in_array($this->validationData, array('post', 'query', 'postredirectget', 'prg'))
        ) {
            if ($this->validationData == 'post') {
                $this->validationData = $this->container->getRequest()->getPost();
            } elseif ($this->validationData == 'query') {
                $this->validationData = $this->container->getRequest()->getQuery();
            } elseif ($this->container->getRequest()->isXmlHttpRequest()) {
                $this->validationData = $this->container->getRequest()->getPost();
            } else {
                $this->validationData = $this->container->getController()->postredirectget();
            }
        }
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
        $this->container = $container;

        if ($container->getRequest()->isXmlHttpRequest()) {
            return $this->handleAjaxRequest();
        }

        return $this->handleNonAjaxRequest();
    }

    private function handleAjaxRequest()
    {
        $form = $this->getForm();

        $data = $this->getValidateAgainst();
        $form->setData($data);
        if ($this->ajaxHandler instanceof Dsl) {
            $this->ajaxHandler->execute($this->container);
        }
    }

    private function handleNonAjaxRequest()
    {
        $form = $this->getForm();
        $data = $this->getValidateAgainst();

        if ($data instanceof Response) {
            $this->container->setResponse($data);
            $this->container->terminate();
            return;
        }

        if ($data
            && count($data) > 0
        ) {
            $form->setData($data);

            if ($form->isValid()) {
                if ($this->successHandler instanceof Dsl) {
                    $this->successHandler->execute($this->container);
                }
            } else {
                if ($this->failureHandler instanceof Dsl) {
                    $this->failureHandler->execute($this->container);
                }
            }
        }
    }
}

