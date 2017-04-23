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
namespace UaNormalizerTest\Generic;

use UaNormalizer\Generic\Android;

/**
 * Class LocaleRemoverTest
 *
 * @group Handlers
 */
class AndroidTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \UaNormalizer\Generic\Android
     */
    private $normalizer = null;

    protected function setUp()
    {
        $this->normalizer = new Android();
    }

    /**
     * @test
     * @dataProvider userAgentsDataProvider
     *
     * @param string $userAgent
     * @param string $expected
     */
    public function testNormalize($userAgent, $expected)
    {
        $found = $this->normalizer->normalize($userAgent);
        self::assertSame($expected, $found);
    }

    public function userAgentsDataProvider()
    {
        return [
            [
                'DDG-Android-2.1.9',
                'DDG-Android-2.1.9',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 2.1-update1; de-de; MB511 Build/RUTEM_U3_01.14.2) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17',
                'Mozilla/5.0 (Linux; U; Android 2.1.1; de-de; MB511 Build/RUTEM_U3_01.14.2) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; de-de; SAMSUNG GT-I9301I/I9301IXXUANI1 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Version/1.5 Chrome/28.0.1500.94 Mobile Safari/537.36',
                'Mozilla/5.0 (Linux; Android 4.4.2; de-de; SAMSUNG GT-I9301I/I9301IXXUANI1 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Version/1.5 Chrome/28.0.1500.94 Mobile Safari/537.36',
            ],
            [
                'MT6582_TD/V1 Linux/3.4.67 Android/4.4.2 Release/ Browser/AppleWebKit537.36 Chrome/30.0.0.0 Mobile Safari/537.36 System/Android 4.4.2',
                'MT6582_TD/V1 Linux/3.4.67 Android/4.4.2 Release/ Browser/AppleWebKit537.36 Chrome/30.0.0.0 Mobile Safari/537.36 System/Android 4.4.2',
            ],
            [
                'Firefox',
                'Firefox',
            ],
        ];
    }
}
