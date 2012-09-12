<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl;

use Zend\Stdlib\ResponseInterface as Response;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class Executor implements ExecutorInterface
{
    /** @var Phrase\PhraseInterface[] */
    private $phrases = array();

    public function addPhrase(Phrase\PhraseInterface $phrase)
    {
        $this->phrases[] = $phrase;
    }

    /** @return Phrase\PhraseInterface[] */
    public function getPhrases()
    {
        return $this->phrases;
    }

    public function execute(ContainerInterface $container)
    {
        foreach ($this->phrases as $phrase) {
            $phraseResult = $phrase->execute($container);

            if ($phraseResult instanceof Response) {
                return $phraseResult;
            }
        }

        $container->getViewModel()->setVariables($container->getViewVariables());
        return $container->getViewModel();
    }
}

