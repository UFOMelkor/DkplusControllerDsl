<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl\Phrase;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Exception\RuntimeException;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class PhraseManager extends AbstractPluginManager
{
    /**
     * Every phrase should be created new.
     *
     * @var boolean
     */
    protected $shareByDefault = false;


    public function validatePlugin($plugin)
    {
        if ($plugin instanceof PhraseInterface) {
            return;
        }

        throw new RuntimeException('Plugins must implement DkplusControllerDsl\Dsl\Phrase\PhraseInterface');
    }
}
