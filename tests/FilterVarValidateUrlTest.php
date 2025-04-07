<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */
declare (strict_types=1);

namespace pvcTests\filtervar;

use PHPUnit\Framework\TestCase;
use pvc\filtervar\FilterVarValidateUrl;

class FilterVarValidateUrlTest extends TestCase
{
    protected FilterVarValidateUrl $filterVar;

    public function setUp(): void
    {
        $this->filterVar = new FilterVarValidateUrl();
    }

    /**
     * testConstructorAndDefaultBehavior
     * @param string $url
     * @param bool $expectedResult
     * @param string $comment
     * @dataProvider urlDataProvider
     * @covers \pvc\filtervar\FilterVarValidateUrl::__construct
     * @covers \pvc\filtervar\FilterVarValidate::validate
     */
    public function testConstructorAndDefaultBehavior(string $url, bool $expectedResult, string $comment): void
    {
        $actualResult = $this->filterVar->validate($url);
        self::assertEquals($expectedResult, $actualResult, $comment);
    }

    /**
     * urlDataProvider
     * @return array
     */
    public function urlDataProvider(): array
    {
        return [
            ['ftp://ftp.is.co.za.example.org/rfc/rfc1808.txt', true, 'failed url with ftp scheme, host, and path to rfc1088.txt'],
            ['gopher://spinaltap.micro.umn.example.edu/00/Weather/California/Los%20Angeles', true, 'failed url with gopher scheme and space in the last degment of path'],
            ['http://www.math.uio.no.example.net/faq/compression-faq/part1.html', true, 'failed url with http scheme and path to part1.html'],
            ['mailto:mduerst@ifi.unizh.example.gov', true, 'failed url with mailto scheme and hostname ending in .gov'],
            ['news:comp.infosystems.www.servers.unix', true, 'failed url with news scheme and no double slashes before host name'],
            ['telnet://melvyl.ucop.example.edu/', true, 'failed scheme with telnet scheme'],
            ['ldap://[2001:db8::7]/c=GB?objectClass?one', true, 'failed url with ldap scheme and funky host notation'],
            ['tel:+1-816-555-1212', false, 'succeeded on a telephone number and should not have'],
            ['telnet://192.0.2.16:80/', true, 'failed on telnet with ip address and port specified'],
            ['urn:oasis:names:specification:docbook:dtd:xml:4.1.2', false, 'succeeded on a urn and should not have.'],
        ];
    }

    /**
     * @return void
     * @covers \pvc\filtervar\FilterVarValidateUrl::validate
     */
    public function testIllegalCharactersInHostName(): void
    {
        $scheme = 'http://';
        $hostFirstPart = 'no';
        $hostLastPart = 'where.com';

        /**
         * "BELL" control character - illegal
         */
        $illegalChar = chr(0x7);
        $host = $hostFirstPart . $illegalChar . $hostLastPart;

        $url = $scheme . $host;
        self::assertFalse($this->filterVar->validate($url));
    }


    /**
     * testPathRequiredIsRequired
     * @covers \pvc\filtervar\FilterVarValidateUrl::requirePath
     * @covers \pvc\filtervar\FilterVarValidateUrl::isPathRequired
     */
    public function testPathRequiredIsRequired(): void
    {
        self::assertFalse($this->filterVar->isPathRequired());
        $this->filterVar->requirePath();
        self::assertTrue($this->filterVar->isPathRequired());
    }

    /**
     * testQueryRequiredIsQueryRequired
     * @covers \pvc\filtervar\FilterVarValidateUrl::requireQuery
     * @covers \pvc\filtervar\FilterVarValidateUrl::isQueryRequired
     */
    public function testQueryRequiredIsQueryRequired(): void
    {
        self::assertFalse($this->filterVar->isQueryRequired());
        $this->filterVar->requireQuery();
        self::assertTrue($this->filterVar->isQueryRequired());
    }

    /**
     * testPathRequired
     * @param string $url
     * @param bool $expectedResult
     * @param string $comment
     * @dataProvider urlPathDataProvider
     * @covers \pvc\filtervar\FilterVarValidate::validate
     */
    public function testPathRequired(string $url, bool $expectedResult, string $comment): void
    {
        $this->filterVar->requirePath();
        $actualResult = $this->filterVar->validate($url);
        self::assertEquals($expectedResult, $actualResult, $comment);
    }

    public function urlPathDataProvider(): array
    {
        return [
            ['http://www.example.com', false, 'wrongly succeeded validating a url with no path'],
            ['http://www.example.com?a=9&b=4', false, 'wrongly succeeded validating a url with no path but has a query'],
            ['http://www.example.com/', true, 'failed validating a url with root path specificed'],
            ['http://www.example.com/news', true, 'failed validating a url with a path specificed'],
        ];
    }

    /**
     * testQueryRequired
     * @param string $url
     * @param bool $expectedResult
     * @param string $comment
     * @dataProvider urlQueryDataProvider
     * @covers \pvc\filtervar\FilterVarValidate::validate
     *
     */
    public function testQueryRequired(string $url, bool $expectedResult, string $comment): void
    {
        $this->filterVar->requireQuery();
        $actualResult = $this->filterVar->validate($url);
        self::assertEquals($expectedResult, $actualResult, $comment);
    }

    /**
     * urlQueryDataProvider
     * @return array[]
     */
    public function urlQueryDataProvider(): array
    {
        return [
            ['http://www.example.com', false, 'wrongly succeeded validating a url with no query'],
            ['http://www.example.com?a=9&b=4', true, 'failed to validate a url with a two parameter query'],
            ['http://www.example.com?a=9', true, 'failed to validate a url with a one parameter query'],
            ['http://www.example.com/?', true, 'failed validating a url with quert that has no parameters'],
        ];
    }

    /**
     * testPathAndQueryRequired
     * @param string $url
     * @param bool $expectedResult
     * @param string $comment
     * @dataProvider urlPathQueryDataProvider
     * @covers \pvc\filtervar\FilterVarValidate::validate
     */
    public function testPathAndQueryRequired(string $url, bool $expectedResult, string $comment): void
    {
        $this->filterVar->requirePath();
        $this->filterVar->requireQuery();
        $actualResult = $this->filterVar->validate($url);
        self::assertEquals($expectedResult, $actualResult, $comment);
    }

    /**
     * urlPathQueryDataProvider
     * @return array[]
     */
    public function urlPathQueryDataProvider(): array
    {
        return [
            ['http://www.example.com/news', false, 'wrongly succeeded validating a url with path but no query'],
            ['http://www.example.com?a=9&b=4', false, 'wrongly validated a url with query but no path'],
            ['http://www.example.com', false, 'wrongly validated a url with no query and no path'],
            ['http://www.example.com/news?a=4', true, 'failed validating a url with query and path'],
        ];
    }
}
