<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl\Phrase;

use DkplusControllerDsl\Dsl\DslInterface as Dsl;
use DkplusControllerDsl\Dsl\ContainerInterface as Container;
use Zend\Form\Exception\DomainException as FormDomainException;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class OnFailure implements ExecutablePhraseInterface
{
    /** @var Dsl */
    private $failureHandler;

    public function __construct(array $options)
    {
        if (isset($options[0])) {
            $this->failureHandler = $options[0];
        }
    }

    public function execute(Container $container)
    {
        if ($container->getRequest()->isXmlHttpRequest()) {
            return;
        }

        $form = $container->getVariable('__FORM__');

        try {
            $isValid = $form->isValid();
        } catch (FormDomainException $e) {
            $isValid = true;
        }

        if (!$isValid) {

            if (\is_callable($this->failureHandler)) {
                $this->failureHandler = \call_user_func($this->failureHandler);
            }

            $this->failureHandler->execute($container);
        }
    }
}
