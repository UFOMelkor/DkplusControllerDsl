<?php
/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */

namespace DkplusControllerDsl\Dsl\Phrase;

use \RuntimeException;

/**
 * @category   Dkplus
 * @package    ControllerDsl
 * @subpackage Dsl\Phrase
 * @author     Oskar Bley <oskar@programming-php.net>
 */
class OptionProvider implements OptionProviderPhraseInterface
{
    /** @var array */
    protected $options;

    /** @var string[] */
    protected $optionNames;

    /** @var boolean */
    protected $throwsExceptionOnMissingValues;

    public function __construct(array $optionNames, array $options, $allowMissingOptions = true)
    {
        $this->options                        = $options;
        $this->optionNames                    = $optionNames;
        $this->throwsExceptionOnMissingValues = !$allowMissingOptions;

        if (count($this->optionNames) < count($this->options)) {
            throw new RuntimeException(
                \sprintf(
                    '%d options provided but only %d option-names',
                    \count($this->options),
                    \count($this->optionNames)
                )
            );
        }

        if ($this->throwsExceptionOnMissingValues
            && count($this->optionNames) > count($this->options)
        ) {
            throw new RuntimeException(
                \sprintf(
                    '%d option-names provided but only %d options',
                    \count($this->optionNames),
                    \count($this->options)
                )
            );
        }
    }

    /** @return string[] */
    public function getOptionNames()
    {
        return $this->optionNames;
    }

    /** @return array */
    public function getOptions()
    {
        $result = array();
        foreach ($this->options as $option) {
            $result[\array_shift($this->optionNames)] = $option;
        }
        return $result;
    }

    /** @return boolean */
    public function isThrowingExceptionOnMissingValues()
    {
        return $this->throwsExceptionOnMissingValues;
    }
}
