<?php

/**
 * This file is part of the ua-normalizer package.
 *
 * Copyright (c) 2015-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace UaNormalizerTest\Normalizer;

use Override;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaNormalizer\Normalizer\Encode;

final class EncodeTest extends TestCase
{
    private Encode $normalizer;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @throws void
     */
    #[Override]
    protected function setUp(): void
    {
        $this->normalizer = new Encode();
    }

    /** @throws ExpectationFailedException */
    #[DataProvider('userAgentsDataProvider')]
    public function testNormalize(string $userAgent, string $expected): void
    {
        $found = $this->normalizer->normalize($userAgent);
        self::assertSame($expected, $found);
    }

    /**
     * @return array<int, array<int, string>>
     *
     * @throws void
     */
    public static function userAgentsDataProvider(): array
    {
        return [
            [
                'Mozilla 2F5.0+ 28Linux 3B+U 3B+Android+12 3B+it-it 3B+Mi+10T+Lite+Build 2FSKQ1.211006.001 29+AppleWebKit 2F537.36+ 28KHTML 2C+like+Gecko 29+Version 2F4.0+Chrome 2F112.0.5615.136+Mobile+Safari 2F537.36+XiaoMi 2FMiuiBrowser 2F13.33.0-gn',
                'Mozilla/5.0+(Linux;+U;+Android+12;+it-it;+Mi+10T+Lite+Build/SKQ1.211006.001)+AppleWebKit/537.36+(KHTML,+like+Gecko)+Version/4.0+Chrome/112.0.5615.136+Mobile+Safari/537.36+XiaoMi/MiuiBrowser/13.33.0-gn',
            ],
            [
                'Mozilla/5.0+ 28Linux 3B+U 3B+Android+12 3B+it-it 3B+Mi+10T+Lite+Build/SKQ1.211006.001 29+AppleWebKit/537.36+ 28KHTML 2C+like+Gecko 29+Version/4.0+Chrome/112.0.5615.136+Mobile+Safari/537.36+XiaoMi/MiuiBrowser/13.33.0-gn',
                'Mozilla/5.0+ 28Linux 3B+U 3B+Android+12 3B+it-it 3B+Mi+10T+Lite+Build/SKQ1.211006.001 29+AppleWebKit/537.36+ 28KHTML 2C+like+Gecko 29+Version/4.0+Chrome/112.0.5615.136+Mobile+Safari/537.36+XiaoMi/MiuiBrowser/13.33.0-gn',
            ],
            [
                'Mozilla 2F5.0+(Linux 3B+U 3B+Android+12 3B+it-it 3B+Mi+10T+Lite+Build 2FSKQ1.211006.001 29+AppleWebKit 2F537.36+(KHTML 2C+like+Gecko 29+Version 2F4.0+Chrome 2F112.0.5615.136+Mobile+Safari 2F537.36+XiaoMi 2FMiuiBrowser 2F13.33.0-gn',
                'Mozilla 2F5.0+(Linux 3B+U 3B+Android+12 3B+it-it 3B+Mi+10T+Lite+Build 2FSKQ1.211006.001 29+AppleWebKit 2F537.36+(KHTML 2C+like+Gecko 29+Version 2F4.0+Chrome 2F112.0.5615.136+Mobile+Safari 2F537.36+XiaoMi 2FMiuiBrowser 2F13.33.0-gn',
            ],
            [
                'Mozilla/5.0+(Linux 3B+U 3B+Android+12 3B+it-it 3B+Mi+10T+Lite+Build/SKQ1.211006.001 29+AppleWebKit/537.36+(KHTML 2C+like+Gecko 29+Version/4.0+Chrome/112.0.5615.136+Mobile+Safari/537.36+XiaoMi/MiuiBrowser/13.33.0-gn',
                'Mozilla/5.0+(Linux 3B+U 3B+Android+12 3B+it-it 3B+Mi+10T+Lite+Build/SKQ1.211006.001 29+AppleWebKit/537.36+(KHTML 2C+like+Gecko 29+Version/4.0+Chrome/112.0.5615.136+Mobile+Safari/537.36+XiaoMi/MiuiBrowser/13.33.0-gn',
            ],
            [
                'Firefox',
                'Firefox',
            ],
            [
                'Mozilla%2F5.0+%28Linux%3B+U%3B+Android+13%3B+de-de%3B+Redmi+Note+12+Pro%2B+5G+Build%2FTP1A.220624.014%29+AppleWebKit%2F537.36+%28KHTML%2C+like+Gecko%29+Version%2F4.0+Chrome%2F112.0.5615.136+Mobile+Safari%2F537.36+XiaoMi%2FMiuiBrowser%2F13.35.0-gn',
                'Mozilla/5.0 (Linux; U; Android 13; de-de; Redmi Note 12 Pro+ 5G Build/TP1A.220624.014) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/112.0.5615.136 Mobile Safari/537.36 XiaoMi/MiuiBrowser/13.35.0-gn',
            ],
        ];
    }
}
