<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl\Executor;

use DkplusControllerDsl\Dsl\Phrase\PhraseInterface as Phrase;
use DkplusControllerDsl\Dsl\Phrase\ContainerAwarePhraseInterface as ContainerAwarePhrase;
use DkplusControllerDsl\Dsl\ContainerInterface as Container;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class ContainerInjectionExecutor implements ExecutorInterface
{
    /** @var Phrase[] */
    private $phrases = array();

    /** @var ExecutorInterface */
    private $decorated;

    public function __construct(ExecutorInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function addPhrase(Phrase $phrase)
    {
        $this->phrases[] = $phrase;
    }

    public function execute(Container $container)
    {
        foreach ($this->phrases as $phrase) {
            if ($phrase instanceof ContainerAwarePhrase) {
                $phrase->setContainer($container);
            }
            $this->decorated->addPhrase($phrase);
        }
        return $this->decorated->execute($container);
    }
}

