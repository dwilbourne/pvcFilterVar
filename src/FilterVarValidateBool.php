<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */
declare(strict_types=1);

namespace pvc\filtervar;

/**
 * Class FilterVarValidateBool
 */
class FilterVarValidateBool extends FilterVarValidate
{
    public function __construct()
    {
        $this->setFilter(FILTER_VALIDATE_BOOL);
        $this->setLabel('boolean');
    }

    public function filterNullOnFailure(): void
    {
        $this->addFlag(FILTER_NULL_ON_FAILURE);
    }
}
