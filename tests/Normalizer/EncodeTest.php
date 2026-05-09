<?php

/**
 * This file is part of the ua-normalizer package.
 *
 * Copyright (c) 2015-2026, Thomas Mueller <mimmi20@live.de>
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
            [
                'Mozilla%2F5.0 (Linux; U; Android 13; de-de; Redmi Note 12 Pro+ 5G Build/TP1A.220624.014) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/112.0.5615.136 Mobile Safari/537.36 XiaoMi/MiuiBrowser/13.35.0-gn',
                'Mozilla/5.0 (Linux; U; Android 13; de-de; Redmi Note 12 Pro+ 5G Build/TP1A.220624.014) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/112.0.5615.136 Mobile Safari/537.36 XiaoMi/MiuiBrowser/13.35.0-gn',
            ],
            [
                'Mozilla/5.0 %28Linux; U; Android 13; de-de; Redmi Note 12 Pro+ 5G Build/TP1A.220624.014) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/112.0.5615.136 Mobile Safari/537.36 XiaoMi/MiuiBrowser/13.35.0-gn',
                'Mozilla/5.0 (Linux; U; Android 13; de-de; Redmi Note 12 Pro+ 5G Build/TP1A.220624.014) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/112.0.5615.136 Mobile Safari/537.36 XiaoMi/MiuiBrowser/13.35.0-gn',
            ],
            [
                'Opera%20Touch/11 CFNetwork/1125.2 Darwin/19.4.0',
                'Opera Touch/11 CFNetwork/1125.2 Darwin/19.4.0',
            ],
            [
                'Incoming!/1.4.3 CFNetwork/454.11.5 Darwin/10.6.0 (i386) (MacBookAir2%2C1)',
                'Incoming!/1.4.3 CFNetwork/454.11.5 Darwin/10.6.0 (i386) (MacBookAir2,1)',
            ],
            [
                'AI%C2%A0Chat/1742 CFNetwork/1496.0.7 Darwin/23.5.0',
                'AI Chat/1742 CFNetwork/1496.0.7 Darwin/23.5.0',
            ],
            [
                '%4D%6F%7A%69%6C%6C%61%2F%35%2E%30%2F%2A%2A%2F%28%57%69%6E%64%6F%77%73%2F%2A%2A%2F%4E%54%2F%2A%2A%2F%31%30%2E%30%3B%2F%2A%2A%2F%57%69%6E%36%34%3B%2F%2A%2A%2F%78%36%34%29%2F%2A%2A%2F%41%70%70%6C%65%57%65%62%4B%69%74%2F%35%33%37%2E%33%36%2F%2A%2A%2F%28%4B%48%54%4D%4C%2C%2F%2A%2A%2F%4C%69%6B%45%2F%2A%2A%2F%47%65%63%6B%6F%29%2F%2A%2A%2F%43%68%72%6F%6D%65%2F%31%34%36%2E%30%2E%30%2E%30%2F%2A%2A%2F%53%61%66%61%72%69%2F%35%33%37%2E%33%36%22%3B%57%41%49%54%46%4F%52%20%44%45%4C%41%59%20%27%30%3A%30%3A%35%27%2D%2D',
                'Mozilla/5.0/**/(Windows/**/NT/**/10.0;/**/Win64;/**/x64)/**/AppleWebKit/537.36/**/(KHTML,/**/LikE/**/Gecko)/**/Chrome/146.0.0.0/**/Safari/537.36";WAITFOR DELAY \'0:0:5\'--',
            ],
        ];
    }
}
