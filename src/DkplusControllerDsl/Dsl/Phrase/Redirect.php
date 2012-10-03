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
class Redirect implements ModifiablePhraseInterface
{
    /** @var string */
    private $route;

    /** @var string */
    private $url;

    /** @var array|callable */
    private $params = array();

    /** @return string */
    public function getRoute()
    {
        return $this->route;
    }

    /** @return string */
    public function getUrl()
    {
        return $this->url;
    }

    public function setOptions(array $options)
    {
        if (isset($options['route'])) {
            $this->route = $options['route'];
        }

        if (isset($options['url'])) {
            $this->url = $options['url'];
        }

        if (isset($options['with'])) {
            $this->params = $options['with'];
        }
    }

    public function execute(Container $container)
    {
        if ($this->route && $this->url) {
            throw new \RuntimeException('Could not redirect to url and route');
        } elseif ($this->route) {
            $params = \is_callable($this->params)
                    ? \call_user_func($this->params, $container)
                    : $this->params;
            $container->setResponse($container->getController()->redirect()->toRoute($this->route, $params));
        } elseif ($this->url) {
            $container->setResponse($container->getController()->redirect()->toUrl($this->url));
        } else {
            throw new \RuntimeException('Needs an url or a route');
        }
    }
}
