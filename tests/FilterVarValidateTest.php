<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */
declare (strict_types=1);

namespace pvcTests\filtervar;

use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use pvc\filtervar\FilterVarValidate;


class FilterVarValidateTest extends TestCase
{
    protected FilterVarValidate|MockObject $filterVar;

    public function setUp(): void
    {
        $filter = FILTER_VALIDATE_URL;
        $this->filterVar = new FilterVarValidate();
        $this->filterVar->setFilter($filter);
    }

    /**
     * testValidate
     */
    #[CoversMethod(FilterVarValidate::class, 'validate')]
    public function testValidate(): void
    {
        self::assertTrue($this->filterVar->validate('http://www.example.com'));
    }

    /**
     * @return void
     */
    #[CoversMethod(FilterVarValidate::class, 'testValue')]
    public function testTestValue(): void
    {
        self::assertTrue($this->filterVar->testValue('http://www.example.com'));
    }
}
