<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl\Executor;

use RuntimeException;
use DkplusControllerDsl\Dsl\Phrase\PhraseInterface as Phrase;
use DkplusControllerDsl\Dsl\Phrase\PrePhraseInterface as PrePhrase;
use DkplusControllerDsl\Dsl\Phrase\PostPhraseInterface as PostPhrase;
use DkplusControllerDsl\Dsl\Phrase\ExecutablePhraseInterface as ExecutablePhrase;
use DkplusControllerDsl\Dsl\Phrase\ModifiablePhraseInterface as ModifiablePhrase;
use DkplusControllerDsl\Dsl\ContainerInterface as Container;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class PrePostExecutorDecorator implements ExecutorInterface
{
    /** @var PrePhrase[] */
    private $prePhrases = array();

    /** @var ExecutablePhrase */
    private $lastModifiablePhrase;

    /** @var ExecutorInterface */
    private $decorated;

    public function __construct(ExecutorInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function addPhrase(Phrase $phrase)
    {
        if ($phrase instanceof PostPhrase) {

            if ($this->lastModifiablePhrase == null) {
                throw new RuntimeException('Needs a modifiable phrase to be added before');
            }

            $this->lastModifiablePhrase->setOptions($phrase->getOptions());
        }

        if ($phrase instanceof ModifiablePhrase) {
            foreach ($this->prePhrases as $prePhrase) {
                $phrase->setOptions($prePhrase->getOptions());
            }
            $this->prePhrases = array();
            $this->lastModifiablePhrase = $phrase;
        }

        if ($phrase instanceof ExecutablePhrase) {
            $this->decorated->addPhrase($phrase);
        }

        if ($phrase instanceof PrePhrase) {
            $this->prePhrases[] = $phrase;
        }
    }

    public function execute(Container $container)
    {
        return $this->decorated->execute($container);
    }
}
