<?php

/**
 * @package pvcRegex
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @noinspection PhpCSValidationInspection
 */

declare (strict_types=1);

namespace pvc\filtervar\err;

use pvc\err\XDataAbstract;
use pvc\interfaces\err\XDataInterface;

/**
 * Class _FilterVarXData
 */
class _FilterVarXData extends XDataAbstract implements XDataInterface
{

    public function getLocalXCodes(): array
    {
        return [
            InvalidFilterException::class => 1000,
            InvalidLabelException::class => 1001,
        ];
    }

    public function getXMessageTemplates(): array
    {
        return [
            InvalidFilterException::class => 'error trying to set filter to an invalid value.',
            InvalidLabelException::class => 'error setting label to an invalid value - cannot be an empty string.'
        ];
    }
}
