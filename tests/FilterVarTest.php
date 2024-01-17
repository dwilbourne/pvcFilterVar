<?php
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */
declare(strict_types=1);

namespace pvcTests\filtervar;

use PHPUnit\Framework\TestCase;
use pvc\filtervar\err\InvalidLabelException;
use pvc\filtervar\FilterVar;

/**
 * Class FilterVarTest
 */

class FilterVarTest extends TestCase
{
    /**
     * @var FilterVar
     */
    protected FilterVar $filterVar;
    public function setUp(): void
    {
        $filter = FILTER_SANITIZE_EMAIL;
        $this->filterVar = new FilterVar($filter);
    }

    /**
     * testSetGetFilter
     * @covers \pvc\filtervar\FilterVar::setFilter
     * @covers \pvc\filtervar\FilterVar::getFilter
     */
    public function testSetGetFilter(): void
    {
        $testFilter = FILTER_VALIDATE_EMAIL;
        $this->filterVar->setFilter($testFilter);
        self::assertEquals($testFilter, $this->filterVar->getFilter());
    }

    /**
     * testSetlabelThrowsExceptionWithEmptyString
     * @throws InvalidLabelException
     * @covers \pvc\filtervar\FilterVar::setLabel
     */
    public function testSetlabelThrowsExceptionWithEmptyString(): void
    {
        self::expectException(InvalidLabelException::class);
        $this->filterVar->setLabel('');
    }

    /**
     * testSetGetlabel
     * @covers \pvc\filtervar\FilterVar::setLabel
     * @covers \pvc\filtervar\FilterVar::getLabel
     */
    public function testSetGetlabel(): void
    {
        $label = 'foo';
        $this->filterVar->setLabel($label);
        self::assertEquals($label, $this->filterVar->getLabel());
    }



    /**
     * testSetGetFilterThrowsExceptionWithBadFilter
     * @throws \pvc\filtervar\err\InvalidFilterException
     * @covers \pvc\filtervar\FilterVar::setFilter
     */
    public function testSetGetFilterThrowsExceptionWithBadFilter(): void
    {
        self::expectException(\pvc\filtervar\err\InvalidFilterException::class);
        $this->filterVar->setFilter(71);
    }

    /**
     * testAddOptionGetOptionsArray
     * @covers \pvc\filtervar\FilterVar::getOptions
     */
    public function testGetOptionsArrayReturnsEmptyArrayAsDefault(): void
    {
        self::assertIsArray($this->filterVar->getOptions());
        self::assertEmpty($this->filterVar->getOptions());
    }

    /**
     * testAddOptionGetOptions
     * @covers \pvc\filtervar\FilterVar::addOption
     * @covers \pvc\filtervar\FilterVar::getOptions
     */
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
     * testAddFlagReturnsNullByDefault
     * @covers \pvc\filtervar\FilterVar::getFlags
     */
    public function testAddFlagReturnsEmptyArrayByDefault(): void
    {
        self::assertIsArray($this->filterVar->getFlags());
        self::assertEmpty($this->filterVar->getFlags());
    }

    /**
     * testAddFlag
     * @covers \pvc\filtervar\FilterVar::addFlag
     * @covers \pvc\filtervar\FilterVar::getFlags
     */
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
     * @covers \pvc\filtervar\FilterVar::getOptionsFlagsArray
     */
    public function testGetOptionsFlagsArrayReturnsEmptyArrayByDefault(): void
    {
        self::assertIsArray($this->filterVar->getOptionsFlagsArray());
        self::assertEmpty($this->filterVar->getOptionsFlagsArray());
    }

    /**
     * testGetOptionsFlagsArray
     * @covers \pvc\filtervar\FilterVar::getOptionsFlagsArray
     */
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

}
