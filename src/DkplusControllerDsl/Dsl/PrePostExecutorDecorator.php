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
    private $lastModifiablePhrase;

    /** @var ExecutorInterface */
    private $decorated;

    public function __construct(ExecutorInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function addPhrase(Phrase\PhraseInterface $phrase)
    {
        if ($phrase instanceof Phrase\PostPhraseInterface) {

            if ($this->lastModifiablePhrase == null) {
                throw new RuntimeException('Needs a modifiable phrase to be added before');
            }

            $this->lastModifiablePhrase->setOptions($phrase->getOptions());
        }

        if ($phrase instanceof Phrase\ModifiablePhraseInterface) {
            foreach ($this->prePhrases as $prePhrase) {
                $phrase->setOptions($prePhrase->getOptions());
            }
            $this->prePhrases = array();
            $this->lastModifiablePhrase = $phrase;
        }

        if ($phrase instanceof Phrase\ExecutablePhraseInterface) {
            $this->decorated->addPhrase($phrase);
        }

        if ($phrase instanceof Phrase\PrePhraseInterface) {
            $this->prePhrases[] = $phrase;
        }
    }

    public function execute(ContainerInterface $container)
    {
        return $this->decorated->execute($container);
    }
}

