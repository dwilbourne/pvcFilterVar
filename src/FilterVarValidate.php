<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */
declare(strict_types=1);

namespace pvc\filtervar;

use pvc\interfaces\filtervar\FilterVarValidateInterface;

/**
 * Class FilterVarValidate
 */
class FilterVarValidate extends FilterVar implements FilterVarValidateInterface
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
