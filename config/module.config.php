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
            'against'       => 'DkplusControllerDsl\Dsl\Phrase\Against',
            'and'           => 'DkplusControllerDsl\Dsl\Phrase\AndPhrase',
            'asJson'        => 'DkplusControllerDsl\Dsl\Phrase\AsJson',
            'as'            => 'DkplusControllerDsl\Dsl\Phrase\AsPhrase',
            'assign'        => 'DkplusControllerDsl\Dsl\Phrase\Assign',
            'data'          => 'DkplusControllerDsl\Dsl\Phrase\Data',
            'disableLayout' => 'DkplusControllerDsl\Dsl\Phrase\DisableLayout',
            'error'         => 'DkplusControllerDsl\Dsl\Phrase\Error',
            'fill'          => 'DkplusControllerDsl\Dsl\Phrase\Fill',
            'form'          => 'DkplusControllerDsl\Dsl\Phrase\Form',
            'formData'      => 'DkplusControllerDsl\Dsl\Phrase\FormData',
            'formMessages'  => 'DkplusControllerDsl\Dsl\Phrase\FormMessages',
            'info'          => 'DkplusControllerDsl\Dsl\Phrase\Info',
            'into'          => 'DkplusControllerDsl\Dsl\Phrase\Into',
            'message'       => 'DkplusControllerDsl\Dsl\Phrase\Message',
            'onAjaxRequest' => 'DkplusControllerDsl\Dsl\Phrase\OnAjaxRequest',
            'onFailure'     => 'DkplusControllerDsl\Dsl\Phrase\OnFailure',
            'onSuccess'     => 'DkplusControllerDsl\Dsl\Phrase\OnSuccess',
            'redirect'      => 'DkplusControllerDsl\Dsl\Phrase\Redirect',
            'route'         => 'DkplusControllerDsl\Dsl\Phrase\Route',
            'store'         => 'DkplusControllerDsl\Dsl\Phrase\Store',
            'success'       => 'DkplusControllerDsl\Dsl\Phrase\Success',
            'to'            => 'DkplusControllerDsl\Dsl\Phrase\ToPhrase',
            'url'           => 'DkplusControllerDsl\Dsl\Phrase\Url',
            'use'           => 'DkplusControllerDsl\Dsl\Phrase\UsePhrase',
            'warning'       => 'DkplusControllerDsl\Dsl\Phrase\Warning',
            'with'          => 'DkplusControllerDsl\Dsl\Phrase\WithPhrase',
        ),
        'aliases' => array(
            'onAjax'   => 'onAjaxRequest',
            'validate' => 'fill'
        )
    )
);
