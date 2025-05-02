<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */
declare(strict_types=1);

namespace pvc\filtervar;


use pvc\filtervar\err\InvalidFilterException;
use pvc\filtervar\err\InvalidLabelException;
use pvc\interfaces\filtervar\FilterVarInterface;

/**
 * Class FilterVar
 */
class FilterVar implements FilterVarInterface
{
    /**
     * @var int
     */
    protected int $filter;

    /**
     * @var array <string, mixed>
     */
    protected array $options = [];

    /**
     * @var array<int, int>
     */
    protected array $flags = [];

    /**
     * @var string
     * describes what the thing is that is being validated.  For example, for a url, set the label to 'url'
     */
    protected string $label;

    /**
     * getLabel
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * setLabel
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        if (empty($label)) {
            throw new InvalidLabelException();
        }
        $this->label = $label;
    }

    /**
     * setFilter
     * @param int $filter
     * @throws InvalidFilterException
     */
    public function setFilter(int $filter): void
    {
        /**
         * keys are the constant values, values are string name of each constant
         */
        $filtervarConstants = array_flip(get_defined_constants(true)['filter']);

        /**
         * callback will be used to remove constants which are flags and options and leave only those constants
         * which are legitimate filters.
         *
         * @param string $constant
         * @return bool
         */
        $callback = function(string $constant): bool {
            $filterPrefixes = ['FILTER_VALIDATE', 'FILTER_SANITIZE', 'FILTER_CALLBACK'];
            /**
             * luckily, we can take advantage of the fact that the prefix strings each have the same string length!
             */
            $constantPrefix = substr($constant, 0, 15);
            return in_array($constantPrefix, $filterPrefixes);
        };
        $filters = array_filter($filtervarConstants, $callback);

        /**
         * array keys are the constant values so if $filter is a key in the array, then it's a legit filter
         */
        if (!array_key_exists($filter, $filters)) {
            throw new InvalidFilterException();
        }
        
        $this->filter = $filter;
    }

    /**
     * getFilter
     * @return int
     */
    public function getFilter(): int
    {
        return $this->filter;
    }

    /**
     * addOption
     * @param string $filterVarOption
     * @param mixed $value
     */
    public function addOption(string $filterVarOption, mixed $value): void
    {
        $this->options[$filterVarOption] = $value;
    }

    /**
     * getOptions
     * @return array<string, mixed>
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * addFlag
     * @param int $filterFlag
     */
    public function addFlag(int $filterFlag): void
    {
        $this->flags[] = $filterFlag;
    }

    /**
     * getFlags
     * @return int[]
     */
    public function getFlags(): array
    {
        return $this->flags;
    }

    /**
     * getOptionsFlagsArray
     * @return array<string, mixed>
     */
    public function getOptionsFlagsArray(): array
    {
        $optionsFlagsArray = [];

        if ($this->getOptions()) {
            $optionsFlagsArray['options'] = $this->getOptions();
        }

        if ($this->getFlags()) {
            $callback = function(int $carry, int $item): int {
                $carry |= $item;
                return $carry;
            };
            $optionsFlagsArray['flags'] = array_reduce($this->getFlags(), $callback, 0);
        }

        return $optionsFlagsArray;
    }

    /**
     * @param  string  $value
     *
     * @return mixed
     */
    public function filter(string $value): mixed
    {
        return filter_var($value, $this->getFilter(),
            $this->getOptionsFlagsArray());
    }
}
