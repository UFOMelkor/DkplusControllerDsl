<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl\Executor;

use DkplusControllerDsl\Dsl\Phrase\PhraseInterface as Phrase;
use DkplusControllerDsl\Dsl\Phrase\ExecutablePhraseInterface as ExecutablePhrase;
use DkplusControllerDsl\Dsl\ContainerInterface as Container;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class Executor implements ExecutorInterface
{
    /** @var Phrase\ExecutablePhraseInterface[] */
    private $phrases = array();

    public function addPhrase(Phrase $phrase)
    {
        if (!$phrase instanceof ExecutablePhrase) {
            return;
        }
        $this->phrases[] = $phrase;
    }

    /** @return Phrase\ExecutablePhraseInterface[] */
    public function getPhrases()
    {
        return $this->phrases;
    }

    public function execute(Container $container)
    {
        foreach ($this->phrases as $phrase) {
            $phrase->execute($container);

            if ($container->isTerminated()) {
                break;
            }
        }

        return $container->getResult();
    }
}

