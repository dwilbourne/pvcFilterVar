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
     * validate
     * @param string $value
     * @return bool
     */
    public function validate(string $value): bool
    {
        return (false !== filter_var($value, $this->getFilter(), $this->getOptionsFlagsArray()));
    }
}