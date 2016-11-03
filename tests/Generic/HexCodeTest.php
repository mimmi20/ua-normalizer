<?php

namespace UaNormalizerTest\Generic;

use UaNormalizer\Generic\HexCode;
use UaNormalizerTest\TestBase;

/**
 * Class LocaleRemoverTest
 *
 * @group Handlers
 */
class HexCodeTest extends TestBase
{
    protected function setUp()
    {
        $this->normalizer = new HexCode();
    }

    /**
     * @test
     * @dataProvider userAgentsDataProvider
     *
     * @param string $userAgent
     * @param string $expected
     */
    public function shouldNormalizeTheHexCodeToken($userAgent, $expected)
    {
        $found = $this->normalizer->normalize($userAgent);
        self::assertEquals($expected, $found);
    }

    public function userAgentsDataProvider()
    {
        return array(
            array(
                'QuickTime\\\\xaa.7.0.4 (qtver=7.0.4;cpu=PPC;os=Mac 10.3.9)',
                'QuickTime.7.0.4 (qtver=7.0.4;cpu=PPC;os=Mac 10.3.9)',
            ),
            array(
                'QuickTime\\xaa.7.0.4 (qtver=7.0.4;cpu=PPC=Mac 10.3.9)',
                'QuickTime.7.0.4 (qtver=7.0.4;cpu=PPC=Mac 10.3.9)',
            ),
            array(
                'QuickTime.7.6.6',
                'QuickTime.7.6.6',
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
