<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl;

use BadMethodCallException;
use InvalidArgumentException;
use Zend\Mvc\Controller\AbstractController;
use Zend\Stdlib\RequestInterface as Request;
use Zend\Stdlib\ResponseInterface as Response;
use Zend\View\Model\ModelInterface as ViewModel;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class Container implements ContainerInterface
{
    /** @var AbstractController */
    private $controller;

    /** @var Request */
    private $request;

    /** @var Response */
    private $response;

    /** @var ViewModel */
    private $viewModel;

    /** @var boolean */
    private $responseLocked = false;

    /** @var boolean */
    private $viewModelLocked = false;

    /** @var array */
    private $viewVariables = array();

    /** @var boolean */
    private $terminated = false;

    /** @var array */
    private $variables = array();

    /** @var boolean */
    private $returnViewModel = true;

    public function __construct(AbstractController $controller, ViewModel $viewModel)
    {
        $this->controller = $controller;
        $this->request    = $controller->getRequest();
        $this->response   = $controller->getResponse();
        $this->viewModel  = $viewModel;
    }

    /** @return AbstractController */
    public function getController()
    {
        return $this->controller;
    }

    /** @return Request */
    public function getRequest()
    {
        return $this->request;
    }

    /** @return Response */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param Response $response
     * @throws BadMethodCallException when the response is locked
     */
    public function setResponse(Response $response)
    {
        if ($this->responseLocked) {
            throw new Exception\ResultLocked('response');
        }
        $this->response        = $response;
        $this->returnViewModel = false;
    }

    public function lockResponse()
    {
        $this->responseLocked = true;
    }

    public function getViewModel()
    {
        return $this->viewModel;
    }

    /**
     * @param ViewModel $model
     * @throws BadMethodCallException when the view model is locked
     */
    public function setViewModel(ViewModel $model)
    {
        if ($this->viewModelLocked) {
            throw new Exception\ResultLocked('view model');
        }
        $this->viewModel       = $model;
        $this->returnViewModel = true;
    }

    public function lockViewModel()
    {
        $this->viewModelLocked = true;
    }

    /** @return array */
    public function getViewVariables()
    {
        return $this->viewVariables;
    }

    public function setViewVariable($variable, $value)
    {
        $this->viewVariables[$variable] = $value;
    }

    public function setViewVariables(array $variables)
    {
        $this->viewVariables = $variables;
    }

    /** @return boolean */
    public function isTerminated()
    {
        return $this->terminated;
    }

    public function terminate()
    {
        $this->terminated = true;
    }

    /**
     * @param string $variable
     * @throws InvalidArgumentException on non existing variable
     */
    public function getVariable($variable)
    {
        if (!isset($this->variables[$variable])) {
            throw new Exception\VariableNotFound($variable);
        }
        return $this->variables[$variable];
    }

    public function setVariable($variable, $value)
    {
        $this->variables[$variable] = $value;
    }

    public function getResult()
    {
        if (!$this->returnViewModel) {
            return $this->response;
        }

        $this->viewModel->setVariables($this->viewVariables);
        return $this->viewModel;
    }
}
