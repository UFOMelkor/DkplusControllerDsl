<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Test
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Test;

use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Test
 * @author     Oskar Bley <oskar@programming-php.net>
 * @covers     DkplusControllerDsl\Test\DslExpectations
 */
class DslExpectationsTest extends TestCase
{
    /**
     * @test
     * @group unit
     * @group Component/Test
     */
    public function canTestWhetherThePageIsMarkedAsNotFound()
    {
        $dsl = $this->expectsDsl()->toMarkPageAsNotFound();
        $dsl->pageNotFound();
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     */
    public function failsTestWhetherThePageIsMarkedAsNotFoundWhenNotMarked()
    {
        $exceptionThrown = false;
        try {
            $dsl = $this->expectsDsl()->toMarkPageAsNotFound();
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->pageNotFound();
            $exceptionThrown = true;
        }
        $this->assertTrue($exceptionThrown);
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     */
    public function canTestWhetherThePageIsMarkedAsNotFoundAndIgnoresZf404Handling()
    {
        $dsl = $this->expectsDsl()->toMarkPageAsNotFound(true);
        $dsl->pageNotFound()->ignore404NotFoundController();
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     */
    public function failsTestWhetherThePageIsMarkedAsNotFoundAndIgnoresZf404HandlingWhenNotIgnoring()
    {
        $exceptionThrown = false;
        try {
            $dsl = $this->expectsDsl()->toMarkPageAsNotFound(true);
            $dsl->pageNotFound();
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->ignore404NotFoundController();
            $exceptionThrown = true;
        }
        $this->assertTrue($exceptionThrown);
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     */
    public function canTestWhetherTheContentIsReplacedWithAnotherControllerAction()
    {
        $dsl = $this->expectsDsl()->toReplaceContentWithControllerAction();
        $dsl->replaceContent()->controllerAction('FooController', 'bar');
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     */
    public function failsTestWhetherTheContentIsReplacedWhenNoContentReplacingHasBeenDone()
    {
        $exceptionThrown = false;
        try {
            $dsl = $this->expectsDsl()->toReplaceContentWithControllerAction();
            $dsl->controllerAction('FooController', 'bar');
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->replaceContent();
            $exceptionThrown = true;
        }
        $this->assertTrue($exceptionThrown);
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     */
    public function failsTestWhetherTheContentIsReplacedWhenNoControllerActionHasBeenGiven()
    {
        $exceptionThrown = false;
        try {
            $dsl = $this->expectsDsl()->toReplaceContentWithControllerAction();
            $dsl->replaceContent();
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->controllerAction('FooController', 'bar');
            $exceptionThrown = true;
        }
        $this->assertTrue($exceptionThrown);
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     */
    public function canTestWhetherTheContentIsReplacedWithSpecificControllerAction()
    {
        $dsl = $this->expectsDsl()->toReplaceContentWithControllerAction('FooController', 'bar');
        $dsl->replaceContent()->controllerAction('FooController', 'bar');
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     */
    public function failsTestWhetherTheContentIsReplacedWithSpecificControllerActionWhenAnotherControllerHasBeenGiven()
    {
        $exceptionThrown = false;
        try {
            $dsl = $this->expectsDsl()->toReplaceContentWithControllerAction('FooController', 'bar');
            $dsl->replaceContent()->controllerAction('BarController', 'bar');
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->controllerAction('FooController', 'bar');
            $exceptionThrown = true;
        }
        $this->assertTrue($exceptionThrown);
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     */
    public function failsTestWhetherTheContentIsReplacedWithSpecificControllerActionWhenAnotherActionHasBeenGiven()
    {
        $exceptionThrown = false;
        try {
            $dsl = $this->expectsDsl()->toReplaceContentWithControllerAction('FooController', 'bar');
            $dsl->replaceContent()->controllerAction('FooController', 'baz');
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->controllerAction('FooController', 'bar');
            $exceptionThrown = true;
        }
        $this->assertTrue($exceptionThrown);
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     */
    public function canTestWhetherTheContentIsReplacedWithSpecificRouteParams()
    {
        $dsl = $this->expectsDsl()->toReplaceContentWithControllerAction('FooController', 'bar', array('foo' => 'bar'));
        $dsl->replaceContent()->controllerAction('FooController', 'bar', array('foo' => 'bar'));
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     */
    public function failsTestWhetherTheContentIsReplacedWithSpecificRouteParamsWhenNoParamsHasBeenGiven()
    {
        $exceptionThrown = false;
        try {
            $dsl = $this->expectsDsl()
                        ->toReplaceContentWithControllerAction('FooController', 'bar', array('foo' => 'bar'));
            $dsl->replaceContent()->controllerAction('FooController', 'bar');
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->controllerAction('FooController', 'bar', array('foo' => 'bar'));
            $exceptionThrown = true;
        }
        $this->assertTrue($exceptionThrown);
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     */
    public function failsTestWhetherTheContentIsReplacedWithSpecificRouteParamsWhenOtherParamsHasBeenGiven()
    {
        $exceptionThrown = false;
        try {
            $dsl = $this->expectsDsl()
                        ->toReplaceContentWithControllerAction('FooController', 'bar', array('foo' => 'bar'));
            $dsl->replaceContent()->controllerAction('FooController', 'bar', array('anything' => 'else'));
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->controllerAction('FooController', 'bar', array('foo' => 'bar'));
            $exceptionThrown = true;
        }
        $this->assertTrue($exceptionThrown);
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox can test whether a dsl returns json
     */
    public function canTestWhetherDslReturnsJson()
    {
        $dsl = $this->expectsDsl()->toReturnJson();
        $dsl->asJson();
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox fails test whether a dsl returns json if asJson is not executed
     */
    public function failsTestWhetherDslReturnsJsonIfAsJsonIsNotExecuted()
    {
        $exceptionThrown = false;
        try {
            $dsl = $this->expectsDsl()->toReturnJson();
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->asJson();
            $exceptionThrown = true;
        }
        $this->assertTrue($exceptionThrown);
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     */
    public function canTestWhetherLayoutHasBeenDisabled()
    {
        $dsl = $this->expectsDsl()->toDisableLayout();
        $dsl->disableLayout();
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     */
    public function failsTestWhetherLayoutHasBeenDisabledIfItHasNot()
    {
        $exceptionThrown = false;
        try {
            $dsl = $this->expectsDsl()->toDisableLayout();
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->disableLayout();
            $exceptionThrown = true;
        }
        $this->assertTrue($exceptionThrown);
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox can test whether a redirect to a route has been done
     */
    public function canTestWhetherRedirectToRouteHasBeenDone()
    {
        $dsl = $this->expectsDsl()->toRedirectToRoute();
        $dsl->redirect()->route('foo/bar'); //also ->redirect()->to()->route() will be possible
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox can test whether a redirect to a route has been done
     */
    public function canTestWhetherRedirectToSpecificRouteHasBeenDone()
    {
        $dsl = $this->expectsDsl()->toRedirectToRoute('foo/bar');
        $dsl->redirect()->route('foo/bar'); //also ->redirect()->to()->route() will be possible
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox fails test whether redirect to a route has been done if a redirect has been done to a url
     */
    public function failsTestWhetherRedirectToRouteHasBeenDoneIfRedirectHasBeenDoneToUrl()
    {
        $exceptionThrown = false;
        try {
            $dsl = $this->expectsDsl()->toRedirectToRoute('foo/bar');
            $dsl->redirect()->url('http://www.example.org/');
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->route('foo/bar');
            $exceptionThrown = true;
        }
        $this->assertTrue($exceptionThrown);
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox fails test whether redirect to a route has been done if a redirect has been done to a wrong route
     */
    public function failsTestWhetherRedirectToRouteHasBeenDoneIfRedirectHasBeenDoneToWrongRoute()
    {
        $exceptionThrown = false;
        try {
            $dsl = $this->expectsDsl()->toRedirectToRoute('foo/bar');
            $dsl->redirect()->route('baz');
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->route('foo/bar');
            $exceptionThrown = true;
        }
        $this->assertTrue($exceptionThrown);
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox fails test whether redirect to a route has been done if no redirect has been done
     */
    public function failsTestWhetherRedirectToRouteHasBeenDoneIfNoRedirectHasBeenDone()
    {
        $exceptionThrown = false;
        try {
            $dsl = $this->expectsDsl()->toRedirectToRoute('foo/bar');
            $dsl->route('foo/bar');
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->redirect();
            $exceptionThrown = true;
        }
        $this->assertTrue($exceptionThrown);
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox wan test whether a redirect to a route with parameters has been done.
     */
    public function canTestWhetherRedirectToRouteWithParametersHasBeenDone()
    {
        $dsl = $this->expectsDsl()->toRedirectToRoute('foo/bar', array('foo' => 'bar'));
        $dsl->redirect()->route('foo/bar', array('foo' => 'bar'));
        $dsl->__phpunit_verify();
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox fails test whether redirect to a route has been done if no redirect has been done
     */
    public function failsTestWhetherRedirectToRouteHasBeenDoneWithParametersIfNoParametersHasBeenGiven()
    {
        $exceptionThrown = false;
        try {
            $dsl = $this->expectsDsl()->toRedirectToRoute('foo/bar', array('foo' => 'bar'));
            $dsl->redirect()->route('foo/bar');
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->route('foo/bar', array('foo' => 'bar'));
            $exceptionThrown = true;
        }
        $this->assertTrue($exceptionThrown);
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox can test whether a redirect to an url has been done
     */
    public function canTestWhetherRedirectToAnUrlHasBeenDone()
    {
        $dsl = $this->expectsDsl()->toRedirectToUrl();
        $dsl->redirect()->url('http://www.example.org/'); //also ->redirect()->to()->url() will be possible
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox can test whether a redirect to a specific url has been done
     */
    public function canTestWhetherRedirectToSpecificUrlHasBeenDone()
    {
        $dsl = $this->expectsDsl()->toRedirectToUrl('http://www.example.org/');
        $dsl->redirect()->url('http://www.example.org/'); //also ->redirect()->to()->url() will be possible
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox fails test whether redirect to an url has been done if a redirect has been done to a route
     */
    public function failsTestWhetherRedirectToUrlHasBeenDoneIfRedirectHasBeenDoneToRoute()
    {
        $exceptionThrown = false;
        try {
            $dsl = $this->expectsDsl()->toRedirectToUrl('http://www.example.org/');
            $dsl->redirect()->route('foo/bar');
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->url('http://www.example.org/');
            $exceptionThrown = true;
        }
        $this->assertTrue($exceptionThrown);
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox fails test whether redirect to an url has been done if a redirect has been done to a wrong url
     */
    public function failsTestWhetherRedirectToUrlHasBeenDoneIfRedirectHasBeenDoneToWrongUrl()
    {
        $exceptionThrown = false;
        try {
            $dsl = $this->expectsDsl()->toRedirectToUrl('http://www.example.org/');
            $dsl->redirect()->url('http://www.foobar.baz/');
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->url('http://www.example.org/');
            $exceptionThrown = true;
        }
        $this->assertTrue($exceptionThrown);
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox fails test whether redirect to an url has been done if no redirect has been done
     */
    public function failsTestWhetherRedirectToUrlHasBeenDoneIfNoRedirectHasBeenDone()
    {
        $exceptionThrown = false;
        try {
            $dsl = $this->expectsDsl()->toRedirectToUrl('http://www.example.org/');
            $dsl->url('http://www.example.org/');
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->redirect();
            $exceptionThrown = true;
        }
        $this->assertTrue($exceptionThrown);
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox can test whether a flash message has been added
     */
    public function canTestWhetherFlashMessageHasBeenAdded()
    {
        $dsl = $this->expectsDsl()->toAddFlashMessage();
        $dsl->message('my-message');
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox can test whether a specific flash message has been added
     */
    public function canTestWhetherSpecificFlashMessageHasBeenAdded()
    {
        $dsl = $this->expectsDsl()->toAddFlashMessage('my-message');
        $dsl->message('my-message');
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox can test whether a flash message has been added with a specific namespace
     */
    public function canTestWhetherFlashMessageHasBeenAddedWithSpecifiedNamespace()
    {
        $dsl = $this->expectsDsl()->toAddFlashMessage(null, 'success');
        $dsl->success()->message('my-message');
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox can test whether a specific flash message has been added with a specific namespace
     */
    public function canTestWhetherSpecificFlashMessageHasBeenAddedWithSpecifiedNamespace()
    {
        $dsl = $this->expectsDsl()->toAddFlashMessage('my-message', 'success');
        $dsl->success()->message('my-message');
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox fails test whether a flash message has been added when no message has been added
     */
    public function failsTestWhetherFlashMessageHasBeenAddedWhenNoMessageHasBeenAdded()
    {
        $exceptionThrown = false;
        try {
            $dsl = $this->expectsDsl()->toAddFlashMessage();
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->message('my-message');
            $exceptionThrown = true;
        }
        $this->assertTrue($exceptionThrown);
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox fails test whether a flash message has been added when a wrong message has been added
     */
    public function failsTestWhetherFlashMessageHasBeenAddedWhenWrongMessageHasBeenAdded()
    {
        $exceptionThrown = false;
        try {
            $dsl = $this->expectsDsl()->toAddFlashMessage('my-message');
            $dsl->message('wrong-message');
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->message('my-message');
            $exceptionThrown = true;
        }
        $this->assertTrue($exceptionThrown);
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox fails test whether a flash message has been added with a specific NS when this NS has not been set
     */
    public function failsTestWhetherFlashMessageHasBeenAddedWithSpecificNSWhenThisNSHasNotBeenSet()
    {
        $exceptionThrown = false;
        try {
            $dsl = $this->expectsDsl()->toAddFlashMessage('my-message', 'success');
            $dsl->failure()->message('my-message');
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->success();
            $exceptionThrown = true;
        }
        $this->assertTrue($exceptionThrown);
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox can test whether a variable has been assigned to view
     */
    public function canTestWhetherVariableHasBeenAssignedToView()
    {
        $dsl = $this->expectsDsl()->toAssign('my-var');
        $dsl->assign('my-var');
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox fails test whether a variable has been assigned to view when no variable has been assigned
     */
    public function failsTestWhetherVariableHasBeenAssignedToViewWhenNoVariableHasBeenAssigned()
    {
        $exceptionThrown = false;
        try {
            $dsl = $this->expectsDsl()->toAssign('my-var');
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->assign('my-var');
            $exceptionThrown = true;
        }
        $this->assertTrue($exceptionThrown);
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox fails test whether a variable has been assigned to view when another variable has been assigned
     */
    public function failsTestWhetherVariableHasBeenAssignedToViewWhenAnotherVariableHasBeenAssigned()
    {
        $exceptionThrown = false;
        try {
            $dsl = $this->expectsDsl()->toAssign('my-var');
            $dsl->assign('another-var');
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->assign('my-var');
            $exceptionThrown = true;
        }
        $this->assertTrue($exceptionThrown);
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox can test whether a variable has been assigned to view with an alias
     */
    public function canTestWhetherVariableHasBeenAssignedToViewWithAnAlias()
    {
        $dsl = $this->expectsDsl()->toAssign('my-var', 'my-alias');
        $dsl->assign('my-var')->as('my-alias');
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox fails test whether a variable has been assigned with an alias when no alias has been given
     */
    public function failsTestWhetherVariableHasBeenAssignedWithAnAliasWhenNoAliasHasBeenGiven()
    {
        $exceptionThrown = false;
        try {
            $dsl = $this->expectsDsl()->toAssign('my-var', 'my-alias');
            $dsl->assign('my-var');
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->as('my-alias');
            $exceptionThrown = true;
        }
        $this->assertTrue($exceptionThrown);
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox fails test whether a variable has been assigned with an alias when a wrong alias has been given
     */
    public function failsTestWhetherVariableHasBeenAssignedWithAnAliasWhenWrongAliasHasBeenGiven()
    {
        $exceptionThrown = false;
        try {
            $dsl = $this->expectsDsl()->toAssign('my-var', 'my-alias');
            $dsl->assign('my-var')->as('wrong-alias');
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->as('my-alias');
            $exceptionThrown = true;
        }
        $this->assertTrue($exceptionThrown);
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     */
    public function canTestWhetherNoFlashMessageHasBeenAdded()
    {
        $this->expectsDsl()->toDoNotAddFlashMessages();
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox can test whether a template has been rendered
     */
    public function canTestWhetherTemplateHasBeenRendered()
    {
        $dsl = $this->expectsDsl()->toRender('user/login.phtml');
        $dsl->render('user/login.phtml');
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox fails test whether a template has been rendered when no template has been rendered
     */
    public function failsTestWhetherTemplateHasBeenRenderedWhenNoTemplateHasBeenRendered()
    {
        $exceptionThrown = false;
        try {
            $dsl = $this->expectsDsl()->toRender('user/login.phtml');
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->render('user/login.phtml');
            $exceptionThrown = true;
        }
        $this->assertTrue($exceptionThrown);
    }

    /**
     * @test
     * @group unit
     * @group Component/Test
     * @testdox fails test whether a template has been rendered when a wrong template has been rendered
     */
    public function failsTestWhetherTemplateHasBeenRenderedWhenWrongTemplateHasBeenRendered()
    {
        $exceptionThrown = false;
        try {
            $dsl = $this->expectsDsl()->toRender('user/login.phtml');
            $dsl->render('foo/login.phtml');
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->render('user/login.phtml');
            $exceptionThrown = true;
        }
        $this->assertTrue($exceptionThrown);
    }
}
