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
class OnSuccess implements ExecutablePhraseInterface
{
    /** @var Dsl */
    private $successHandler;

    public function __construct(array $options)
    {
        if (isset($options[0])) {
            $this->successHandler = $options[0];
        }
    }

    public function execute(Container $container)
    {
        $form = $container->getVariable('__FORM__');

        try {
            $isValid = $form->isValid();
        } catch (FormDomainException $e) {
            $isValid = false;
        }

        if ($isValid) {
            if (\is_callable($this->successHandler)) {
                $this->successHandler = \call_user_func($this->successHandler);
            }
            $this->successHandler->execute($container);
        }
    }
}
