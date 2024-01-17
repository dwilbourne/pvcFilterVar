<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */
declare (strict_types=1);

namespace pvcTests\filtervar;

use PHPUnit\Framework\TestCase;
use pvc\filtervar\FilterVarValidateBool;

class FilterVarValidateBoolTest extends TestCase
{
    protected FilterVarValidateBool $filterVar;

    public function setUp(): void
    {
        $this->filterVar = new FilterVarValidateBool();
    }

    public function testTrue(string $input, bool $expectedResult, string $comment): void
    {
        self::assertEquals($expectedResult, $this->filterVar->validate($input), $comment);
    }

    public function trueTestDataProvider(): array
    {
        return [
            ['true', true, 'failed to validate lower case true'],
            ['tRuE', true, 'failed to validate mixed case tRuE'],
            ['yEs', true, 'failed to validate mixed case yEs'],
        ];
    }
}
