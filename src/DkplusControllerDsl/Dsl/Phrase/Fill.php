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
class Fill implements ModifiablePhraseInterface
{
    /** @var \Zend\Form\FormInterface|string */
    private $form;

    /** @var array|string */
    private $data;

    public function __construct(array $options)
    {
        $this->form = isset($options[0])
                    ? $options[0]
                    : 'form';

        if (isset($options[1])) {
            $this->data = $options[1];
        }
    }

    public function setOptions(array $options)
    {
        if (isset($options['data'])) {
            $this->data = $options['data'];
        }

        if (isset($options['form'])) {
            $this->form = $options['form'];
        }
    }

    public function execute(Container $container)
    {
        $form = \is_string($this->form)
              ? $container->getVariable($this->form)
              : $this->form;

        $data = $this->getData($container);

        $container->setVariable('__FORM__', $form);

        if (!$container->getRequest()->isXmlHttpRequest()
            && $data instanceOf Response
        ) {
            $container->setResponse($data);
            $container->terminate();
        } elseif ($data !== false) {
            $form->setData($data);
        }
    }

    private function getData(Container $container)
    {
        if (\is_string($this->data)
            && \in_array($this->data, array('post', 'query', 'postredirectget', 'prg'))
        ) {
            if ($this->data == 'post') {
                $this->data = $container->getRequest()->getPost();
            } elseif ($this->data == 'query') {
                $this->data = $container->getRequest()->getQuery();
            } elseif ($container->getRequest()->isXmlHttpRequest()) {
                $this->data = $container->getRequest()->getPost();
            } else {
                $this->data = $container->getController()->postredirectget();
            }
        }
        return $this->data;
    }
}
