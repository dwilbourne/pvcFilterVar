<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */
declare (strict_types=1);


use PHPUnit\Framework\MockObject\MockObject;
use pvc\filtervar\FilterVarValidate;
use PHPUnit\Framework\TestCase;

class FilterVarValidateTest extends TestCase
{
    protected FilterVarValidate|MockObject $filterVar;

    public function setUp(): void
    {
        $filter = FILTER_VALIDATE_URL;
        $this->filterVar = new FilterVarValidate($filter);
    }

    /**
     * testValidate
     * @covers \pvc\filtervar\FilterVarValidate::validate
     */
    public function testValidate(): void
    {
        self::assertTrue($this->filterVar->validate('http://www.example.com'));
    }
}
