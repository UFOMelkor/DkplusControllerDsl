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
}
