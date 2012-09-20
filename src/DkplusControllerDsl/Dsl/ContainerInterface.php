<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl;

use Zend\Stdlib\ResponseInterface as Response;
use Zend\View\Model\ModelInterface as ViewModel;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 */
interface ContainerInterface
{
    /** @return \Zend\Mvc\Controller\AbstractController */
    public function getController();

    /** @return \Zend\Stdlib\RequestInterface */
    public function getRequest();

    /** @return Response */
    public function getResponse();

    /**
     * @param Response $response
     * @throws \BadMethodCallException when the response is locked
     */
    public function setResponse(Response $response);

    public function lockResponse();

    /** @return ViewModel */
    public function getViewModel();

    /**
     * @param ViewModel $model
     * @throws \BadMethodCallException when the view model is locked
     */
    public function setViewModel(ViewModel $model);

    public function lockViewModel();

    public function terminate();

    public function isTerminated();

    public function setViewVariable($variable, $value);

    public function setViewVariables(array $variables);

    public function getViewVariables();

    /**
     * @param string $variable
     * @throws \InvalidArgumentException on non existing variable
     */
    public function getVariable($variable);

    public function setVariable($variable, $value);

    /** @return \Zend\Stdlib\ResponseInterface|Zend\View\Model\ModelInterface */
    public function getResult();
}

