<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl\Phrase;

use DkplusUnitTest\TestCase;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class RedirectTest extends TestCase
{
    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @testdox is a modifiable phrase
     */
    public function isModifiablePhrase()
    {
        $this->assertInstanceOf('DkplusControllerDsl\Dsl\Phrase\ModifiablePhraseInterface', new Redirect());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canRetrieveRouteFromOptions()
    {
        $route = 'home';

        $phrase = new Redirect();
        $phrase->setOptions(array('route' => $route));
        $this->assertEquals($route, $phrase->getRoute());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canRetrieveUrlFromOptions()
    {
        $url = 'http://www.example.org/';

        $phrase = new Redirect();
        $phrase->setOptions(array('url' => $url));
        $this->assertEquals($url, $phrase->getUrl());
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canRedirectToRoute()
    {
        $route    = 'home';
        $response = $this->getMockForAbstractClass('Zend\Stdlib\ResponseInterface');

        $redirector = $this->getMock('Zend\Mvc\Controller\Plugin\Redirect');
        $redirector->expects($this->once())
                   ->method('toRoute')
                   ->with($route)
                   ->will($this->returnValue($response));

        $container = $this->getContainerMockRedirector($redirector);
        $container->expects($this->once())
                  ->method('setResponse')
                  ->with($response);

        $phrase = new Redirect();
        $phrase->setOptions(array('route' => $route));

        $phrase->execute($container);
    }

    private function getContainerMockRedirector($redirector)
    {
        $controller = $this->getMockBuilder('Zend\Mvc\Controller\AbstractActionController')
                           ->setMethods(array('redirect'))
                           ->getMock();
        $controller->expects($this->any())
                   ->method('redirect')
                   ->will($this->returnValue($redirector));

        $container  = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');
        $container->expects($this->any())
                  ->method('getController')
                  ->will($this->returnValue($controller));

        return $container;
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     */
    public function canRedirectToUrl()
    {
        $url      = 'http://www.example.org/';
        $response = $this->getMockForAbstractClass('Zend\Stdlib\ResponseInterface');

        $redirector = $this->getMock('Zend\Mvc\Controller\Plugin\Redirect');
        $redirector->expects($this->once())
                   ->method('toUrl')
                   ->with($url)
                   ->will($this->returnValue($response));

        $container = $this->getContainerMockRedirector($redirector);
        $container->expects($this->once())
                  ->method('setResponse')
                  ->with($response);

        $phrase = new Redirect();
        $phrase->setOptions(array('url' => $url));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @expectedException RuntimeException
     * @expectedExceptionMessage Could not redirect to url and route
     */
    public function doesNotAcceptRouteAndUrl()
    {
        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');

        $phrase = new Redirect();
        $phrase->setOptions(array('url' => 'http://www.example.org/', 'route' => 'home'));
        $phrase->execute($container);
    }

    /**
     * @test
     * @group Component/Dsl
     * @group Module/DkplusControllerDsl
     * @expectedException RuntimeException
     * @expectedExceptionMessage Needs url or route
     */
    public function needsUrlOrRoute()
    {
        $container = $this->getMockForAbstractClass('DkplusControllerDsl\Dsl\ContainerInterface');

        $phrase = new Redirect();
        $phrase->execute($container);
    }
}

