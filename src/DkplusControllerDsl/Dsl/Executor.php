<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl;

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

    public function addPhrase(Phrase\PhraseInterface $phrase)
    {
        if (!$phrase instanceof Phrase\ExecutablePhraseInterface) {
            return;
        }
        $this->phrases[] = $phrase;
    }

    /** @return Phrase\ExecutablePhraseInterface[] */
    public function getPhrases()
    {
        return $this->phrases;
    }

    public function execute(ContainerInterface $container)
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

