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
class ReplaceContent implements ModifiablePhraseInterface
{
    /** @var string */
    private $controller;

    /** @var array */
    private $routeParameters;

    public function setOptions(array $options)
    {
        if (isset($options['controller'])) {
            $this->controller = $options['controller'];
        }
        if (isset($options['route_params'])) {
            $this->routeParameters = $options['route_params'];
        }
    }

    public function execute(Container $container)
    {
        $content = $container->getController()->forward()->dispatch($this->controller, $this->routeParameters);
        $container->setViewVariable('content', $content);
        $container->getViewModel()->setTemplate('dsl/replace-content');
    }
}
