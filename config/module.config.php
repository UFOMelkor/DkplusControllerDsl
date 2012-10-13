<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Config
 * @author     Oskar Bley <oskar@programming-php.net>
 */
return array(
    'phrases' => array(
        'invokables' => array(
            'add'              => 'DkplusControllerDsl\Dsl\Phrase\NullPhrase',
            'against'          => 'DkplusControllerDsl\Dsl\Phrase\Against',
            'and'              => 'DkplusControllerDsl\Dsl\Phrase\NullPhrase',
            'asJson'           => 'DkplusControllerDsl\Dsl\Phrase\AsJson',
            'as'               => 'DkplusControllerDsl\Dsl\Phrase\AsPhrase',
            'assign'           => 'DkplusControllerDsl\Dsl\Phrase\Assign',
            'controllerAction' => 'DkplusControllerDsl\Dsl\Phrase\ControllerAction',
            'data'             => 'DkplusControllerDsl\Dsl\Phrase\Data',
            'disableLayout'    => 'DkplusControllerDsl\Dsl\Phrase\DisableLayout',
            'error'            => 'DkplusControllerDsl\Dsl\Phrase\Error',
            'fill'             => 'DkplusControllerDsl\Dsl\Phrase\Fill',
            'form'             => 'DkplusControllerDsl\Dsl\Phrase\Form',
            'formData'         => 'DkplusControllerDsl\Dsl\Phrase\FormData',
            'formMessages'     => 'DkplusControllerDsl\Dsl\Phrase\FormMessages',
            'info'             => 'DkplusControllerDsl\Dsl\Phrase\Info',
            'into'             => 'DkplusControllerDsl\Dsl\Phrase\Into',
            'message'          => 'DkplusControllerDsl\Dsl\Phrase\Message',
            'notFound'         => 'DkplusControllerDsl\Dsl\Phrase\NotFound',
            'onAjaxRequest'    => 'DkplusControllerDsl\Dsl\Phrase\OnAjaxRequest',
            'onFailure'        => 'DkplusControllerDsl\Dsl\Phrase\OnFailure',
            'onSuccess'        => 'DkplusControllerDsl\Dsl\Phrase\OnSuccess',
            'redirect'         => 'DkplusControllerDsl\Dsl\Phrase\Redirect',
            'replaceContent'   => 'DkplusControllerDsl\Dsl\Phrase\ReplaceContent',
            'responseCode'     => 'DkplusControllerDsl\Dsl\Phrase\ResponseCode',
            'route'            => 'DkplusControllerDsl\Dsl\Phrase\Route',
            'set'              => 'DkplusControllerDsl\Dsl\Phrase\NullPhrase',
            'store'            => 'DkplusControllerDsl\Dsl\Phrase\Store',
            'success'          => 'DkplusControllerDsl\Dsl\Phrase\Success',
            'to'               => 'DkplusControllerDsl\Dsl\Phrase\NullPhrase',
            'url'              => 'DkplusControllerDsl\Dsl\Phrase\Url',
            'use'              => 'DkplusControllerDsl\Dsl\Phrase\UsePhrase',
            'warning'          => 'DkplusControllerDsl\Dsl\Phrase\Warning',
            'with'             => 'DkplusControllerDsl\Dsl\Phrase\WithPhrase',
        ),
        'aliases' => array(
            'onAjax'   => 'onAjaxRequest',
            'validate' => 'fill'
        )
    ),
    'view_manager' => array(
        'template_map' => array(
            'dsl/replace-content' => __DIR__ . '/../view/dsl/replace-content.phtml',
        ),
    ),
);
