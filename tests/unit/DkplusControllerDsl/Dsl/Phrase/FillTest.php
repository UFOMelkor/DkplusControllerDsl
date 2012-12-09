<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl\Phrase;

use PHPUnit_Framework_TestCase as TestCase;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class FillTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group unit
     * @testdox is a modifiable phrase
     */
    public function isModifiablePhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\ModifiablePhraseInterface', new Fill(array()));
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function canRetrieveFormFromConstructorOptions()
    {
        $form   = $this->getMockForAbstractClass('Zend\Form\FormInterface');
        $form->expects($this->once())
             ->method('setData');

        $phrase = new Fill(array($form));
        $phrase->execute($this->getContainerWithRequest());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function canRetrieveFormFromOptions()
    {
        $form   = $this->getMockForAbstractClass('Zend\Form\FormInterface');
        $form->expects($this->once())
             ->method('setData');

        $phrase = new Fill(array());
        $phrase->setOptions(array('form' => $form));
        $phrase->execute($this->getContainerWithRequest());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function canRetrieveDataFromConstructorOptions()
    {
        $data = array('foo', 'bar');
        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');
        $form->expects($this->once())
             ->method('setData')
             ->with($data);

        $phrase = new Fill(array($form, $data));
        $phrase->execute($this->getContainerWithRequest());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function canRetrieveDataFromOptions()
    {
        $data = array('foo', 'bar');
        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');
        $form->expects($this->once())
             ->method('setData')
             ->with($data);

        $phrase = new Fill(array($form));
        $phrase->setOptions(array('data' => $data));
        $phrase->execute($this->getContainerWithRequest());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function canRetrieveFormFromContainer()
    {
        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');
        $form->expects($this->once())
             ->method('setData');

        $container = $this->getContainerWithRequest();
        $container->expects($this->any())
                  ->method('getVariable')
                  ->with('form')
                  ->will($this->returnValue($form));

        $phrase = new Fill(array());
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function canUseConfigurableKeyToRetrieveFormFromContainer()
    {
        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');
        $form->expects($this->once())
             ->method('setData');

        $container = $this->getContainerWithRequest();
        $container->expects($this->any())
                  ->method('getVariable')
                  ->with('my-form')
                  ->will($this->returnValue($form));

        $phrase = new Fill(array('my-form'));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function canUsePostData()
    {
        $postData = array('foo' => 'bar', 'bar' => 'baz');

        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');
        $form->expects($this->once())
             ->method('setData')
             ->with($postData);

        $container = $this->getContainerWithRequest();
        $request   = $container->getRequest();
        $request->expects($this->any())
                ->method('getPost')
                ->will($this->returnValue($postData));

        $phrase = new Fill(array($form, 'post'));
        $phrase->execute($container);
    }


    /** @return \DkplusControllerDsl\Dsl\ContainerInterface|\PHPUnit_Framework_MockObject_MockObject */
    private function getContainerWithRequest()
    {
        $request = $this->getMock('Zend\Http\Request');

        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $container->expects($this->any())
                  ->method('getRequest')
                  ->will($this->returnValue($request));
        return $container;
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function canUseQueryData()
    {
        $getData = array('foo' => 'bar', 'bar' => 'baz');

        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');
        $form->expects($this->once())
             ->method('setData')
             ->with($getData);

        $container = $this->getContainerWithRequest();
        $request   = $container->getRequest();
        $request->expects($this->any())
                ->method('getQuery')
                ->will($this->returnValue($getData));

        $phrase = new Fill(array($form, 'query'));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function canUseDataStoredByPostRedirectGet()
    {
        $sessionData = array('foo' => 'bar', 'bar' => 'baz');

        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');
        $form->expects($this->once())
             ->method('setData')
             ->with($sessionData);

        $controller = $this->getMock('Zend\Mvc\Controller\AbstractActionController', array('postredirectget'));
        $controller->expects($this->any())
                   ->method('postredirectget')
                   ->will($this->returnValue($sessionData));

        $container = $this->getContainerWithRequest();
        $container->expects($this->any())
                  ->method('getController')
                  ->will($this->returnValue($controller));

        $phrase = new Fill(array($form, 'postredirectget'));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function doesNothingWhenUsingPrgAndFalseIsReturned()
    {
        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');
        $form->expects($this->never())
             ->method('setData');

        $controller = $this->getMock('Zend\Mvc\Controller\AbstractActionController', array('postredirectget'));
        $controller->expects($this->any())
                   ->method('postredirectget')
                   ->will($this->returnValue(false));

        $container = $this->getContainerWithRequest();
        $container->expects($this->any())
                  ->method('getController')
                  ->will($this->returnValue($controller));

        $container->expects($this->never())
                  ->method('setResponse');
        $container->expects($this->never())
                  ->method('terminate');

        $phrase = new Fill(array($form, 'postredirectget'));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function redirectsWhenUsingPostRedirectGetAndPostDataAreGiven()
    {

        $response = $this->getMockForAbstractClass('Zend\Stdlib\ResponseInterface');

        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');
        $form->expects($this->never())
             ->method('setData');

        $controller = $this->getMock('Zend\Mvc\Controller\AbstractActionController', array('postredirectget'));
        $controller->expects($this->any())
                   ->method('postredirectget')
                   ->will($this->returnValue($response));

        $container = $this->getContainerWithRequest();
        $container->expects($this->any())
                  ->method('getController')
                  ->will($this->returnValue($controller));
        $container->expects($this->once())
                  ->method('setResponse')
                  ->with($response);
        $container->expects($this->once())
                  ->method('terminate');

        $phrase = new Fill(array($form, 'postredirectget'));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function redirectsOnlyWhenNoAjaxRequest()
    {
        $postData = array('foo' => 'bar', 'baz' => 'bar');

        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');
        $form->expects($this->once())
             ->method('setData')
             ->with($postData);

        $container = $this->getContainerWithRequest();
        $request   = $container->getRequest();
        $request->expects($this->any())
                ->method('isXmlHttpRequest')
                ->will($this->returnValue(true));
        $request->expects($this->any())
                ->method('getPost')
                ->will($this->returnValue($postData));

        $phrase = new Fill(array($form, 'postredirectget'));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function storesFormIntoContainer()
    {
        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');

        $container = $this->getContainerWithRequest();
        $container->expects($this->at(0))
                  ->method('setVariable')
                  ->with('__FORM__', $form);

        $phrase = new Fill(array($form));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group unit
     */
    public function setsATrueMustValidateFlagWhenNoAjaxRequestIsDetectedAndFormDataExisting()
    {
        $form = $this->getMockForAbstractClass('Zend\Form\FormInterface');

        $container = $this->getContainerWithRequest();
        $container->expects($this->at(4))
                  ->method('setVariable')
                  ->with('__MUST_VALIDATE__', true);

        $request   = $container->getRequest();
        $request->expects($this->any())
                ->method('getQuery')
                ->will($this->returnValue(array('foo' => 'bar')));

        $phrase = new Fill(array($form, 'query'));
        $phrase->execute($container);
    }
}
