<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */
declare(strict_types=1);

namespace pvc\filtervar;

/**
 * Class FilterVarValidateBool
 * see tests.  FilterVar will return true for case-insensitive strings of true, yes, on and the character 1.
 * Returns false for case-insensitive strings of false, no, off and 0.  The FILTER_NULL_ON_FAILURE sets the behavior
 * so that it returns null if the string argument is some other string.  So we need to override the validate method
 * inherited from the parent class because this flavor of filter_var behaves like a filter, not like a validator.  In
 * other words, we want to return true if the input is true or false, and return false if it is some other non-boolean
 * kind of string such as 'foo'
 */
class FilterVarValidateBool extends FilterVarValidate
{
    public function __construct()
    {
        $this->setFilter(FILTER_VALIDATE_BOOL);
        $this->addFlag(FILTER_NULL_ON_FAILURE);
        $this->setLabel('boolean');
    }

    public function validate(string $value): bool
    {
        return !is_null(filter_var($value, $this->getFilter(), $this->getOptionsFlagsArray()));
    }
}
