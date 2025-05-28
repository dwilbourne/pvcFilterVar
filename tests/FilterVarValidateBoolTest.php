<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */
declare (strict_types=1);

namespace pvcTests\filtervar;

use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;
use pvc\filtervar\FilterVarValidateBool;

class FilterVarValidateBoolTest extends TestCase
{
    protected FilterVarValidateBool $filterVar;

    public function setUp(): void
    {
        $this->filterVar = new FilterVarValidateBool();
    }

    /**
     * testConstruct
     */
    #[CoversMethod(FilterVarValidateBool::class, '__construct')]
    public function testConstruct(): void
    {
        self::assertInstanceOf(FilterVarValidateBool::class, $this->filterVar);
    }

    /**
     * testValidate
     * @param string $input
     * @param bool $expectedResult
     * @param string $comment
     */
    #[CoversMethod(FilterVarValidateBool::class, 'validate')]
    #[\PHPUnit\Framework\Attributes\DataProvider('trueTestDataProvider')]
    public function testValidate(string $input, bool $expectedResult, string $comment): void
    {
        self::assertEquals($expectedResult, $this->filterVar->validate($input), $comment);
    }

    /**
     * trueTestDataProvider
     * @return array[]
     */
    public static function trueTestDataProvider(): array
    {
        return [
            ['true', true, 'failed to validate lower case true'],
            ['tRuE', true, 'failed to validate mixed case tRuE'],
            ['yEs', true, 'failed to validate mixed case yEs'],
            ['oN', true, 'failed to validate mixed case oN'],
            ['1', true, 'failed to validate \'1\''],
            ['false', true, 'failed to validate false'],
            ['no', true, 'failed to validate no'],
            ['off', true, 'failed to validate off'],
            ['0', true, 'failed to validate \'0\''],
            ['foo', false, 'wrongly validated foo'],
        ];
    }
}
