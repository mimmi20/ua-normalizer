<?php
/**
 * This file is part of the ua-normalizer package.
 *
 * Copyright (c) 2015-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace UaNormalizerTest\Specific;

use UaNormalizer\Specific\Firefox;
use UaNormalizerTest\TestBase;

/**
 * Class FirefoxTest
 *
 * @group Handlers
 */
class FirefoxTest extends TestBase
{
    protected function setUp()
    {
        $this->normalizer = new Firefox();
    }

    /**
     * @test
     * @dataProvider firefoxUserAgentsDataProvider
     *
     * @param string $userAgent
     * @param string $expected
     */
    public function shoudReturnOnlyFirefoxStringWithTheMajorVersion($userAgent, $expected)
    {
        $found = $this->normalizer->normalize($userAgent);
        self::assertEquals($expected, $found);
    }

    public function firefoxUserAgentsDataProvider()
    {
        return [
            [
                'Mozilla/5.0 (X11; U; Linux armv6l; en-US; rv:1.9a6pre) Gecko/20070810 Firefox/3.0a1',
                'Firefox/3.0a1',
            ],
            ['Firefox/3.x', 'Firefox/3.x'],
            ['Mozilla', 'Mozilla'],
            ['Firefox', 'Firefox'],
        ];
    }
}
