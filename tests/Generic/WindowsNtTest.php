<?php

namespace UaNormalizerTest\Generic;

use UaNormalizer\Generic\WindowsNt;
use UaNormalizerTest\TestBase;

/**
 * Class LocaleRemoverTest
 *
 * @group Handlers
 */
class WindowsNtTest extends TestBase
{
    protected function setUp()
    {
        $this->normalizer = new WindowsNt();
    }

    /**
     * @test
     * @dataProvider userAgentsDataProvider
     *
     * @param string $userAgent
     * @param string $expected
     */
    public function shouldNormalizeTheWindowsNtToken($userAgent, $expected)
    {
        $found = $this->normalizer->normalize($userAgent);
        self::assertEquals($expected, $found);
    }

    public function userAgentsDataProvider()
    {
        return array(
            array(
                'Mozilla/4.0 (compatible; Lotus-Notes/6.0; Windows-NT)',
                'Mozilla/4.0 (compatible; Lotus-Notes/6.0; Windows NT)',
            ),
            array(
                'Mozilla',
                'Mozilla',
            ),
            array(
                'Firefox',
                'Firefox',
            ),
        );
    }
}
