<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl;

use RuntimeException;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class PrePostExecutorDecorator implements ExecutorInterface
{
    /** @var Phrase\PrePhraseInterface[] */
    private $prePhrases = array();

    /** @var Phrase\ExecutablePhraseInterface */
    private $lastExecutablePhrase;

    /** @var ExecutorInterface */
    private $decorated;

    public function __construct(ExecutorInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function addPhrase(Phrase\PhraseInterface $phrase)
    {
        if ($phrase instanceof Phrase\PrePhraseInterface) {
            $this->prePhrases[] = $phrase;
            return;
        }

        if ($phrase instanceof Phrase\PostPhraseInterface) {

            if ($this->lastExecutablePhrase == null) {
                throw new RuntimeException('Needs a executable phrase to be added before');
            }

            $this->lastExecutablePhrase->setOptions($phrase->getOptions());
            return;
        }

        foreach ($this->prePhrases as $prePhrase) {
            $phrase->setOptions($prePhrase->getOptions());
        }
        $this->prePhrases = array();

        $this->lastExecutablePhrase = $phrase;
        $this->decorated->addPhrase($phrase);
    }

    public function execute(ContainerInterface $container)
    {
        return $this->decorated->execute($container);
    }
}

