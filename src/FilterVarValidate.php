<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */
declare(strict_types=1);

namespace pvc\filtervar;

use pvc\interfaces\filtervar\FilterVarValidateInterface;

/**
 * Class FilterVarValidate
 * FilterVarValidateInterface extends ValtesterInterface so this object is also
 * a ValTester object
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

    public function testValue(string $value): bool
    {
        return $this->validate($value);
    }
}
