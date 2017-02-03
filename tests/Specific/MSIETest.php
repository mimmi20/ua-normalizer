<?php

namespace UaNormalizerTest\Specific;

use UaNormalizer\Specific\MSIE;
use UaNormalizerTest\TestBase;

/**
 * Class MSIETest
 *
 * @group Handlers
 */
class MSIETest extends TestBase
{
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        $this->normalizer = new MSIE();
    }

    /**
     * @test
     * @dataProvider msieUserAgentsDataProvider
     *
     * @param string $userAgent
     * @param string $expected
     */
    public function shoudRemoveAllTheCharactersAfterTheMinorVersion($userAgent, $expected)
    {
        $this->assertNormalizeEqualsExpected($userAgent, $expected);
    }

    public function msieUserAgentsDataProvider()
    {
        return [
            ['Mozilla/2.0 (compatible; MSIE 3.02; Windows CE; Smartphone; 176x220)', 'Mozilla/2.0 (compatible; MSIE 3.02; Windows CE; Smartphone; 176x220)'],
            ['Mozilla/4.0 (compatible; MSIE 4.01; Windows CE; Smartphone; 176x220)', 'Mozilla/4.0 (compatible; MSIE 4.01; Windows CE; Smartphone; 176x220)'],
            ['MSIE 3.x', 'MSIE 3.x'],
            ['Mozilla', 'Mozilla'],
            ['Firefox', 'Firefox'],

        ];
    }
}
