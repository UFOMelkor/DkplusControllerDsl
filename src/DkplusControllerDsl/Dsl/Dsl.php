<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl;

use Zend\Mvc\Controller\AbstractController;
use Zend\ServiceManager\AbstractPluginManager as PluginManager;
use Zend\View\Model\ViewModel;

/**
 * @category   DkplusControllerDsl
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 * @method \DkplusControllerDsl\Dsl\Dsl add() add()
 * @method \DkplusControllerDsl\Dsl\Dsl against() against(mixed $data)
 * @method \DkplusControllerDsl\Dsl\Dsl and() and()
 * @method \DkplusControllerDsl\Dsl\Dsl as() as(string $alias)
 * @method \DkplusControllerDsl\Dsl\Dsl asJson() asJson()
 * @method \DkplusControllerDsl\Dsl\Dsl assign() assign(mixed $variable = null, string $alias = null)
 * @method \DkplusControllerDsl\Dsl\Dsl
 *          controllerAction()
 *          controllerAction(string $controller, string $action, array $routeParams = array())
 * @method \DkplusControllerDsl\Dsl\Dsl data() data(mixed $data)
 * @method \DkplusControllerDsl\Dsl\Dsl disableLayout() disableLayout()
 * @method \DkplusControllerDsl\Dsl\Dsl error() error()
 * @method \DkplusControllerDsl\Dsl\Dsl fill() fill(\Zend\Form\FormInterface|string $form = null)
 * @method \DkplusControllerDsl\Dsl\Dsl form() form(\Zend\Form\FormInterface|string $form = null)
 * @method \DkplusControllerDsl\Dsl\Dsl formData() formData(\Zend\Form\FormInterface|string $form = null)
 * @method \DkplusControllerDsl\Dsl\Dsl formMessages() formMessages(\Zend\Form\FormInterface|string $form = null)
 * @method \DkplusControllerDsl\Dsl\Dsl info() info()
 * @method \DkplusControllerDsl\Dsl\Dsl into() into(callable $callable)
 * @method \DkplusControllerDsl\Dsl\Dsl message() message(string $message, string $namespace = 'default')
 * @method \DkplusControllerDsl\Dsl\Dsl onAjax() onAjax(\DkplusControllerDsl\Dsl\DslInterface $dsl)
 * @method \DkplusControllerDsl\Dsl\Dsl onAjaxRequest() onAjaxRequest(\DkplusControllerDsl\Dsl\DslInterface $dsl)
 * @method \DkplusControllerDsl\Dsl\Dsl onFailure() onFailure(\DkplusControllerDsl\Dsl\DslInterface $dsl)
 * @method \DkplusControllerDsl\Dsl\Dsl onSuccess() onSuccess(\DkplusControllerDsl\Dsl\DslInterface $dsl)
 * @method \DkplusControllerDsl\Dsl\Dsl redirect() redirect()
 * @method \DkplusControllerDsl\Dsl\Dsl replaceContent() replaceContent()
 * @method \DkplusControllerDsl\Dsl\Dsl route() route(string $route)
 * @method \DkplusControllerDsl\Dsl\Dsl store() store(mixed $data = null)
 * @method \DkplusControllerDsl\Dsl\Dsl success() success()
 * @method \DkplusControllerDsl\Dsl\Dsl to() to()
 * @method \DkplusControllerDsl\Dsl\Dsl url() url(string $url)
 * @method \DkplusControllerDsl\Dsl\Dsl use() use(mixed $variable, string $alias = null)
 * @method \DkplusControllerDsl\Dsl\Dsl validate() validate(\Zend\Form\FormInterface|string $form = null)
 * @method \DkplusControllerDsl\Dsl\Dsl warning() warning()
 * @method \DkplusControllerDsl\Dsl\Dsl with() with()
 */
class Dsl implements DslInterface
{
    /** @var PluginManager */
    private $plugins;

    /** @var Executor\ExecutorInterface */
    private $executor;

    /** @var AbstractController */
    private $controller;

    public function __construct(
        PluginManager $plugins,
        Executor\ExecutorInterface $executor,
        AbstractController $controller
    ) {
        $this->plugins    = $plugins;
        $this->executor   = $executor;
        $this->controller = $controller;
    }

    /** @return PluginManager */
    public function getPluginManager()
    {
        return $this->plugins;
    }

    /** @return ExecutorInterface */
    public function getExecutor()
    {
        return $this->executor;
    }

    /** @return \Zend\Stdlib\ResponseInterface|\Zend\View\Model\ModelInterface */
    public function execute(ContainerInterface $container = null)
    {
        if ($container == null) {
            $container = new Container($this->controller, new ViewModel());
        }
        return $this->executor->execute($container);
    }

    public function __call($method, $arguments)
    {
        $phrase = $this->plugins->get($method, $arguments);
        $this->executor->addPhrase($phrase);
        return $this;
    }
}
