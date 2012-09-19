<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Config
 * @author     Oskar Bley <oskar@programming-php.net>
 */

use DkplusControllerDsl\Controller\Plugin\Dsl;
use Zend\Mvc\Controller\PluginManager;

return array(
    'dsl' => function (PluginManager $manager) {
        $manager = $manager->getServiceLocator()->get('DkplusControllerDsl\Dsl\Phrase\PhraseManager');
        return new Dsl($manager);
    }
);

