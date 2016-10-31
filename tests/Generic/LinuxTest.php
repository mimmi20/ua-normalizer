<?php

namespace UaNormalizerTest\Generic;

use UaNormalizer\Generic\Linux;
use UaNormalizerTest\TestBase;

/**
 * Class LocaleRemoverTest
 *
 * @group Handlers
 */
class LinuxTest extends TestBase
{
    protected function setUp()
    {
        $this->normalizer = new Linux();
    }

    /**
     * @test
     * @dataProvider userAgentsDataProvider
     *
     * @param string $userAgent
     * @param string $expected
     */
    public function shouldNormalizeTheLinuxToken($userAgent, $expected)
    {
        $found = $this->normalizer->normalize($userAgent);
        self::assertEquals($expected, $found);
    }

    public function userAgentsDataProvider()
    {
        return array(
            array(
                'Android (Linus; U; Android 1.5; zh-cn; hero) AppleWebKit/528.5+ (KHTML) Version/3.1.2',
                'Android (Linux; U; Android 1.5; zh-cn; hero) AppleWebKit/528.5+ (KHTML) Version/3.1.2',
            ),
            array(
                'Android (Linux;  U; Android 1.5; zh-cn; hero) AppleWebKit/528.5+ (KHTML) Version/3.1.2',
                'Android (Linux; U; Android 1.5; zh-cn; hero) AppleWebKit/528.5+ (KHTML) Version/3.1.2',
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
