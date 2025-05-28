<?php
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */
declare(strict_types=1);

namespace pvcTests\filtervar;

use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;
use pvc\filtervar\err\InvalidFilterException;
use pvc\filtervar\err\InvalidLabelException;
use pvc\filtervar\FilterVar;

/**
 * Class FilterVarTest
 */
class FilterVarTest extends TestCase
{
    protected FilterVar $filterVar;
    public function setUp(): void
    {
        $this->filterVar = new FilterVar();
    }

    /**
     * testSetFilterThrowsExceptionWithBadFilter
     *
     * @throws InvalidFilterException
     */
    public function testSetFilterThrowsExceptionWithBadFilter(): void
    {
        self::expectException(InvalidFilterException::class);
        $this->filterVar->setFilter(71);
    }

    /**
     * testSetGetFilter
     */
    #[CoversMethod(FilterVar::class, 'setFilter')]
    #[CoversMethod(FilterVar::class, 'getFilter')]

    public function testSetGetFilter(): void
    {
        $testFilter = FILTER_VALIDATE_EMAIL;
        $this->filterVar->setFilter($testFilter);
        self::assertEquals($testFilter, $this->filterVar->getFilter());
    }

    /**
     * testSetlabelThrowsExceptionWithEmptyString
     * @throws InvalidLabelException
     */
    #[CoversMethod(FilterVar::class, 'setLabel')]
    public function testSetlabelThrowsExceptionWithEmptyString(): void
    {
        self::expectException(InvalidLabelException::class);
        $this->filterVar->setLabel('');
    }

    /**
     * testSetGetlabel
     */
    #[CoversMethod(FilterVar::class, 'setLabel')]
    #[CoversMethod(FilterVar::class, 'getLabel')]
    public function testSetGetlabel(): void
    {
        $label = 'foo';
        $this->filterVar->setLabel($label);
        self::assertEquals($label, $this->filterVar->getLabel());
    }


    /**
     * testAddOptionGetOptionsArray
     */
    #[CoversMethod(FilterVar::class, 'getOptions')]
    public function testGetOptionsArrayReturnsEmptyArrayAsDefault(): void
    {
        /** @phpstan-ignore-next-line */
        self::assertIsArray($this->filterVar->getOptions());
        self::assertEmpty($this->filterVar->getOptions());
    }

    /**
     * testAddOptionGetOptions
     */
    #[CoversMethod(FilterVar::class, 'addOption')]
    #[CoversMethod(FilterVar::class, 'getOptions')]
    public function testAddOptionGetOptions(): void
    {
        $optionName = 'foo';
        $optionValue = 24;
        $this->filterVar->addOption($optionName, $optionValue);
        $expectedResult = ['foo' => 24];
        self::assertEquals($expectedResult, $this->filterVar->getOptions());

        $optionName = 'bar';
        $optionValue = 'baz';
        $this->filterVar->addOption($optionName, $optionValue);
        $expectedResult = ['foo' => 24, 'bar' => 'baz'];
        self::assertEquals($expectedResult, $this->filterVar->getOptions());
    }

    /**
     * testGetFlagsReturnsEmptyArrayByDefault
     */
    #[CoversMethod(FilterVar::class, 'getFlags')]
    public function testGetFlagsReturnsEmptyArrayByDefault(): void
    {
        self::assertIsArray($this->filterVar->getFlags());
        self::assertEmpty($this->filterVar->getFlags());
    }

    /**
     * testAddFlag
     */
    #[CoversMethod(FilterVar::class, 'addFlag')]
    #[CoversMethod(FilterVar::class, 'getFlags')]
    public function testAddFlagGetFlags(): void
    {
        $this->filterVar->setFilter(FILTER_SANITIZE_ENCODED);

        $this->filterVar->addFlag(FILTER_FLAG_STRIP_LOW);
        $expectedResult = [FILTER_FLAG_STRIP_LOW];
        self::assertEqualsCanonicalizing($expectedResult, $this->filterVar->getFlags());

        $this->filterVar->addFlag(FILTER_FLAG_STRIP_HIGH);
        $expectedResult = [FILTER_FLAG_STRIP_LOW, FILTER_FLAG_STRIP_HIGH];
        self::assertEqualsCanonicalizing($expectedResult, $this->filterVar->getFlags());
    }

    /**
     * testGetOptionsFlagsArrayReturnsEmptyArrayByDefault
     */
    #[CoversMethod(FilterVar::class, 'getOptionsFlagsArray')]
    public function testGetOptionsFlagsArrayReturnsEmptyArrayByDefault(): void
    {
        self::assertIsArray($this->filterVar->getOptionsFlagsArray());
        self::assertEmpty($this->filterVar->getOptionsFlagsArray());
    }

    /**
     * testGetOptionsFlagsArray
     */
    #[CoversMethod(FilterVar::class, 'getOptionsFlagsArray')]
    public function testGetOptionsFlagsArray(): void
    {
        $this->filterVar->setFilter(FILTER_SANITIZE_ENCODED);

        $this->filterVar->addFlag(FILTER_FLAG_STRIP_LOW);
        $this->filterVar->addFlag(FILTER_FLAG_STRIP_HIGH);

        $this->filterVar->addOption('default', 'foo');

        $expectedResult = [
          'options' => ['default' => 'foo'],
          'flags' =>   FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH
        ];

        self::assertEqualsCanonicalizing($expectedResult, $this->filterVar->getOptionsFlagsArray());
    }

    /**
     * @return void
     * @throws InvalidFilterException
     */
    #[CoversMethod(FilterVar::class, 'filter')]
    public function testFilter(): void
    {
        $this->filterVar->setFilter(FILTER_SANITIZE_NUMBER_FLOAT);
        $this->filterVar->addFlag(FILTER_FLAG_ALLOW_FRACTION);
        $value = '12x.34';
        $expectedResult = '12.34';
        self::assertEquals($expectedResult, $this->filterVar->filter($value));
    }

}
