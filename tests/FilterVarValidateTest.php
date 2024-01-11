<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */
declare (strict_types=1);

namespace pvcTests\filtervar;

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
     * testSetGetlabel
     * @covers \pvc\filtervar\FilterVarValidate::setLabel
     * @covers \pvc\filtervar\FilterVarValidate::getLabel
     */
    public function testSetGetlabel(): void
    {
        $label = 'foo';
        $this->filterVar->setLabel($label);
        self::assertEquals($label, $this->filterVar->getLabel());
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
