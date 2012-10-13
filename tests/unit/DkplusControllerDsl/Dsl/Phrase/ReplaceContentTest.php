<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl\Phrase;

use PHPUnit_Framework_TestCase as TestCase;
use Zend\Mvc\Controller\Plugin\Forward as ForwardPlugin;
use Zend\View\Model\ModelInterface as ViewModel;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class ReplaceContentTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group unit
     * @testdox is a modifiable phrase
     */
    public function isModifiablePhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\ModifiablePhraseInterface', new ReplaceContent());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function dispatchesAnotherControllerAction()
    {
        $forwardPlugin = $this->getMock('Zend\Mvc\Controller\Plugin\Forward');
        $forwardPlugin->expects($this->once())
                      ->method('dispatch')
                      ->with('UserController', array('action' => 'foo'));

        $viewModel = $this->getMockForAbstractClass('Zend\View\Model\ModelInterface');

        $container = $this->getContainerMockWithForwardPluginAndViewModel($forwardPlugin, $viewModel);

        $phrase = new ReplaceContent();
        $phrase->setOptions(array('controller' => 'UserController', 'route_params' => array('action' => 'foo')));
        $phrase->execute($container);
    }

    protected function getContainerMockWithForwardPluginAndViewModel(ForwardPlugin $forwardPlugin, ViewModel $viewModel)
    {
        $controller = $this->getMock('Zend\Mvc\Controller\AbstractActionController', array('forward'));
        $controller->expects($this->any())
                   ->method('forward')
                   ->will($this->returnValue($forwardPlugin));

        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $container->expects($this->any())
                  ->method('getController')
                  ->will($this->returnValue($controller));

        $container->expects($this->any())
                 ->method('getViewModel')
                 ->will($this->returnValue($viewModel));
        return $container;
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function setsViewModelVariableToControllerActionResult()
    {
        $forwardPlugin = $this->getMock('Zend\Mvc\Controller\Plugin\Forward');
        $forwardPlugin->expects($this->any())
                      ->method('dispatch')
                      ->will($this->returnValue('my-content'));

        $viewModel = $this->getMockForAbstractClass('Zend\View\Model\ModelInterface');

        $container = $this->getContainerMockWithForwardPluginAndViewModel($forwardPlugin, $viewModel);
        $container->expects($this->once())
                 ->method('setViewVariable')
                 ->with('content', 'my-content');

        $phrase = new ReplaceContent();
        $phrase->setOptions(array('controller' => 'UserController', 'route_params' => array('action' => 'foo')));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function setsTemplateOfTheViewModel()
    {
        $forwardPlugin = $this->getMock('Zend\Mvc\Controller\Plugin\Forward');
        $viewModel     = $this->getMockForAbstractClass('Zend\View\Model\ModelInterface');
        $viewModel->expects($this->once())
                  ->method('setTemplate')
                  ->with('dsl/replace-content');

        $container = $this->getContainerMockWithForwardPluginAndViewModel($forwardPlugin, $viewModel);

        $phrase = new ReplaceContent();
        $phrase->setOptions(array('controller' => 'UserController', 'route_params' => array('action' => 'foo')));
        $phrase->execute($container);
    }
}
