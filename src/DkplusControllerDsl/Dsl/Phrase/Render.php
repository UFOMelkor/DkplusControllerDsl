<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl\Phrase;

use DkplusControllerDsl\Dsl\ContainerInterface as Container;
use Zend\View\Model\ViewModel;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class Render implements ExecutablePhraseInterface
{
    /** @var string */
    private $template;

    public function __construct(array $options)
    {
        if (isset($options[0])) {
            $this->template = (string) $options[0];
        }
    }

    public function execute(Container $container)
    {
        if ($container->getViewModel() instanceof ViewModel) {
            $container->getViewModel()->setTemplate($this->template);
            return;
        }
        throw new \RuntimeException('Needs an instance of Zend\View\Model\ViewModel as view model');
    }
}
