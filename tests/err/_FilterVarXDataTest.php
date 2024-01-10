<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare (strict_types=1);

namespace pvcTests\filtervar\err;

use pvc\err\XDataTestMaster;
use pvc\filtervar\err\_FilterVarXData;

/**
 * Class _RegexXDataTest
 */
class _FilterVarXDataTest  extends XDataTestMaster
{
    /**
     * @function testPvcRegexExceptionLibrary
     * @covers \pvc\filtervar\err\_FilterVarXData::getXMessageTemplates
     * @covers \pvc\filtervar\err\_FilterVarXData::getLocalXCodes
     * @covers \pvc\filtervar\err\InvalidFilterException::__construct
     */
    public function testPvcRegexExceptionLibrary(): void
    {
        $xData = new _FilterVarXData();
        self::assertTrue($this->verifylibrary($xData));
    }
}