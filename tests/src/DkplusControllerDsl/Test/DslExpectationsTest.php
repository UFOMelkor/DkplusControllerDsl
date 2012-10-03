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
     * @group Module/DkplusControllerDsl
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
     * @group Module/DkplusControllerDsl
     * @group Component/Test
     * @testdox fails test whether a dsl returns json if asJson is not executed
     */
    public function failsTestWhetherDslReturnsJsonIfAsJsonIsNotExecuted()
    {
        try {
            $dsl = $this->expectsDsl()->toReturnJson();
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->asJson();
        }
    }

    /**
     * @test
     * @group Module/DkplusControllerDsl
     * @group Component/Test
     */
    public function canTestWhetherLayoutHasBeenDisabled()
    {
        $dsl = $this->expectsDsl()->toDisableLayout();
        $dsl->disableLayout();
    }

    /**
     * @test
     * @group Module/DkplusControllerDsl
     * @group Component/Test
     */
    public function failsTestWhetherLayoutHasBeenDisabledIfItHasNot()
    {
        try {
            $dsl = $this->expectsDsl()->toDisableLayout();
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->disableLayout();
        }
    }

    /**
     * @test
     * @group Module/DkplusControllerDsl
     * @group Component/Test
     * @testdox can test whether a redirect to a route has been done
     */
    public function canTestWhetherRedirectToRouteHasBeenDone()
    {
        $dsl = $this->expectsDsl()->toRedirectToRoute('foo/bar');
        $dsl->redirect()->route('foo/bar'); //also ->redirect()->to()->route() will be possible
    }

    /**
     * @test
     * @group Module/DkplusControllerDsl
     * @group Component/Test
     * @testdox fails test whether redirect to a route has been done if a redirect has been done to a url
     */
    public function failsTestWhetherRedirectToRouteHasBeenDoneIfRedirectHasBeenDoneToUrl()
    {
        try {
            $dsl = $this->expectsDsl()->toRedirectToRoute('foo/bar');
            $dsl->redirect()->url('http://www.example.org/');
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->route('foo/bar');
        }
    }

    /**
     * @test
     * @group Module/DkplusControllerDsl
     * @group Component/Test
     * @testdox fails test whether redirect to a route has been done if a redirect has been done to a wrong route
     */
    public function failsTestWhetherRedirectToRouteHasBeenDoneIfRedirectHasBeenDoneToWrongRoute()
    {
        try {
            $dsl = $this->expectsDsl()->toRedirectToRoute('foo/bar');
            $dsl->redirect()->route('baz');
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->route('foo/bar');
        }
    }

    /**
     * @test
     * @group Module/DkplusControllerDsl
     * @group Component/Test
     * @testdox fails test whether redirect to a route has been done if no redirect has been done
     */
    public function failsTestWhetherRedirectToRouteHasBeenDoneIfNoRedirectHasBeenDone()
    {
        try {
            $dsl = $this->expectsDsl()->toRedirectToRoute('foo/bar');
            $dsl->route('foo/bar');
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->redirect();
        }
    }

    /**
     * @test
     * @group Module/DkplusControllerDsl
     * @group Component/Test
     * @testdox can test whether a redirect to an url has been done
     */
    public function canTestWhetherRedirectToUrlHasBeenDone()
    {
        $dsl = $this->expectsDsl()->toRedirectToUrl('http://www.example.org/');
        $dsl->redirect()->url('http://www.example.org/'); //also ->redirect()->to()->url() will be possible
    }

    /**
     * @test
     * @group Module/DkplusControllerDsl
     * @group Component/Test
     * @testdox fails test whether redirect to an url has been done if a redirect has been done to a route
     */
    public function failsTestWhetherRedirectToUrlHasBeenDoneIfRedirectHasBeenDoneToRoute()
    {
        try {
            $dsl = $this->expectsDsl()->toRedirectToUrl('http://www.example.org/');
            $dsl->redirect()->route('foo/bar');
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->url('http://www.example.org/');
        }
    }

    /**
     * @test
     * @group Module/DkplusControllerDsl
     * @group Component/Test
     * @testdox fails test whether redirect to an url has been done if a redirect has been done to a wrong url
     */
    public function failsTestWhetherRedirectToUrlHasBeenDoneIfRedirectHasBeenDoneToWrongUrl()
    {
        try {
            $dsl = $this->expectsDsl()->toRedirectToUrl('http://www.example.org/');
            $dsl->redirect()->url('http://www.foobar.baz/');
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->url('http://www.example.org/');
        }
    }

    /**
     * @test
     * @group Module/DkplusControllerDsl
     * @group Component/Test
     * @testdox fails test whether redirect to an url has been done if no redirect has been done
     */
    public function failsTestWhetherRedirectToUrlHasBeenDoneIfNoRedirectHasBeenDone()
    {
        try {
            $dsl = $this->expectsDsl()->toRedirectToUrl('http://www.example.org/');
            $dsl->url('http://www.example.org/');
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->redirect();
        }
    }

    /**
     * @test
     * @group Module/DkplusControllerDsl
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
     * @group Module/DkplusControllerDsl
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
     * @group Module/DkplusControllerDsl
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
     * @group Module/DkplusControllerDsl
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
     * @group Module/DkplusControllerDsl
     * @group Component/Test
     * @testdox fails test whether a flash message has been added when no message has been added
     */
    public function failsTestWhetherFlashMessageHasBeenAddedWhenNoMessageHasBeenAdded()
    {
        try {
            $dsl = $this->expectsDsl()->toAddFlashMessage();
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->message('my-message');
        }
    }

    /**
     * @test
     * @group Module/DkplusControllerDsl
     * @group Component/Test
     * @testdox fails test whether a flash message has been added when a wrong message has been added
     */
    public function failsTestWhetherFlashMessageHasBeenAddedWhenWrongMessageHasBeenAdded()
    {
        try {
            $dsl = $this->expectsDsl()->toAddFlashMessage('my-message');
            $dsl->message('wrong-message');
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->message('my-message');
        }
    }

    /**
     * @test
     * @group Module/DkplusControllerDsl
     * @group Component/Test
     * @testdox fails test whether a flash message has been added with a specific NS when this NS has not been set
     */
    public function failsTestWhetherFlashMessageHasBeenAddedWithSpecificNSWhenThisNSHasNotBeenSet()
    {
        try {
            $dsl = $this->expectsDsl()->toAddFlashMessage('my-message', 'success');
            $dsl->failure()->message('my-message');
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->success();
        }
    }

    /**
     * @test
     * @group Module/DkplusControllerDsl
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
     * @group Module/DkplusControllerDsl
     * @group Component/Test
     * @testdox fails test whether a variable has been assigned to view when no variable has been assigned
     */
    public function failsTestWhetherVariableHasBeenAssignedToViewWhenNoVariableHasBeenAssigned()
    {
        try {
            $dsl = $this->expectsDsl()->toAssign('my-var');
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->assign('my-var');
        }
    }

    /**
     * @test
     * @group Module/DkplusControllerDsl
     * @group Component/Test
     * @testdox fails test whether a variable has been assigned to view when another variable has been assigned
     */
    public function failsTestWhetherVariableHasBeenAssignedToViewWhenAnotherVariableHasBeenAssigned()
    {
        try {
            $dsl = $this->expectsDsl()->toAssign('my-var');
            $dsl->assign('another-var');
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->assign('my-var');
        }
    }

    /**
     * @test
     * @group Module/DkplusControllerDsl
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
     * @group Module/DkplusControllerDsl
     * @group Component/Test
     * @testdox fails test whether a variable has been assigned with an alias when no alias has been given
     */
    public function failsTestWhetherVariableHasBeenAssignedWithAnAliasWhenNoAliasHasBeenGiven()
    {
        try {
            $dsl = $this->expectsDsl()->toAssign('my-var', 'my-alias');
            $dsl->assign('my-var');
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->as('my-alias');
        }
    }

    /**
     * @test
     * @group Module/DkplusControllerDsl
     * @group Component/Test
     * @testdox fails test whether a variable has been assigned with an alias when a wrong alias has been given
     */
    public function failsTestWhetherVariableHasBeenAssignedWithAnAliasWhenWrongAliasHasBeenGiven()
    {
        try {
            $dsl = $this->expectsDsl()->toAssign('my-var', 'my-alias');
            $dsl->assign('my-var')->as('wrong-alias');
            $dsl->__phpunit_verify();
        } catch (\PHPUnit_Framework_ExpectationFailedException $e) {
            $dsl->as('my-alias');
        }
    }
}
