<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare (strict_types=1);

namespace pvcTests\filtervar\err;

use PHPUnit\Framework\Attributes\CoversMethod;
use pvc\err\XDataTestMaster;
use pvc\filtervar\err\_FilterVarXData;
use pvc\filtervar\err\InvalidFilterException;

/**
 * Class _RegexXDataTest
 */
class _FilterVarXDataTest  extends XDataTestMaster
{
    /**
     * @function testPvcRegexExceptionLibrary
     */
    #[CoversMethod(_FilterVarXData::class, 'getXMessageTemplates')]
    #[CoversMethod(_FilterVarXData::class, 'getLocalXCodes')]
    #[CoversMethod(InvalidFilterException::class, '__construct')]
    public function testPvcRegexExceptionLibrary(): void
    {
        $xData = new _FilterVarXData();
        self::assertTrue($this->verifylibrary($xData));
    }
}