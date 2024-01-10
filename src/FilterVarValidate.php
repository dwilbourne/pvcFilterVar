<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */
declare(strict_types=1);

namespace pvc\filtervar;

/**
 * Class FilterVarValidate
 */
class FilterVarValidate extends FilterVar
{
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
        $this->label = $label;
    }



    /**
     * validate
     * @param string $value
     * @return bool
     */
    public function validate(string $value): bool
    {
        return (false !== filter_var($value, $this->getFilter(), $this->getOptionsFlagsArray()));
    }
}