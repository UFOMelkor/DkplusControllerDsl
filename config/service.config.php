<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Config
 * @author     Oskar Bley <oskar@programming-php.net>
 */

use DkplusControllerDsl\Dsl\Phrase\PhraseManager;
use Zend\ServiceManager\Config;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;

return array(
    'DkplusControllerDsl\Dsl\Phrase\PhraseManager' => function (ServiceLocator $locator) {
        $config = $locator->get('Config');

        $result = new PhraseManager(new Config($config['phrases']));
        $result->setServiceLocator($locator);
        $result->addPeeringServiceManager($locator);
        return $result;
    }
);
