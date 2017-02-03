<?php

namespace UaNormalizerTest\Specific;

use UaNormalizer\Specific\Chrome;
use UaNormalizerTest\TestBase;

/**
 * Class ChromeTest
 *
 * @group Handlers
 */
class ChromeTest extends TestBase
{
    const CHROME_USERAGENTS_FILE = 'chrome.txt';

    protected function setUp()
    {
        $this->normalizer = new Chrome();
    }

    /**
     * @test
     * @dataProvider chromeUserAgentsDataProvider
     *
     * @param string $userAgent
     * @param string $expected
     */
    public function shoudReturnOnlyFirefoxStringWithTheMajorVersion($userAgent, $expected)
    {
        $found = $this->normalizer->normalize($userAgent);
        $this->assertEquals($found, $expected);
    }

    public function chromeUserAgentsDataProvider()
    {
        return [
            ['Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/1838444932.621444948.1409104071.2120334063 Safari/537.36', 'Chrome/1838444932.621444948.1409104071.2120334063 Safari/537.36'],
        ];
    }
}
