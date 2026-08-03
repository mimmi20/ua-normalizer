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

namespace Normalizer;

use Override;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaNormalizer\Normalizer\RemoveBuild;

final class RemoveBuildTest extends TestCase
{
    private RemoveBuild $normalizer;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @throws void
     */
    #[Override]
    protected function setUp(): void
    {
        $this->normalizer = new RemoveBuild();
    }

    /** @throws ExpectationFailedException */
    #[DataProvider('userAgentsDataProvider')]
    public function testShouldNormalize(string $userAgent, string $expected): void
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
                'Mozilla/5.0 (Linux; Android 13; TECNO TECNO KJ6; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/149.0.7827.91 Mobile Safari/537.36 Sapphire/1.11.1',
                'Mozilla/5.0 (Linux; Android 13; TECNO TECNO KJ6; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/149.0.7827.91 Mobile Safari/537.36 Sapphire/1.11.1',
            ],
            [
                'Mozilla/5.0 (Linux; Android 14; moto e15 Build/UUTB34.40-36; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/141.0.7390.97 Mobile Safari/537.36 NSTNWV/3.129.815524762.31release.go',
                'Mozilla/5.0 (Linux; Android 14; moto e15) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/141.0.7390.97 Mobile Safari/537.36 NSTNWV/3.129.815524762.31release.go',
            ],
            [
                'com.google.android.apps.searchlite/961535 (Linux; U; Android 13; de­_DE; 23028RN4DG; Build/TP1A.220624.014; Cronet/126.0.6423.0)',
                'com.google.android.apps.searchlite/961535 (Linux; U; Android 13; de­_DE; 23028RN4DG; Cronet/126.0.6423.0)',
            ],
            [
                'NRC Audio/2.0.0 (nl.nrc.audio; build:29; Android 12; Sdk:31; Manufacturer:samsung; Model: SM-G975F) OkHttp/4.9.3',
                'NRC Audio/2.0.0 (nl.nrc.audio; build:29; Android 12; Sdk:31; Manufacturer:samsung; Model: SM-G975F) OkHttp/4.9.3',
            ],
            [
                'ozilla/5.0 (Linux; U; Android 4.1.2; en-us; HUAWEI G610-C00 Build HuaweiG610-C00) UC AppleWebKit 534.31 (KHTML, like Gecko) Mobile Safari 534.31',
                'ozilla/5.0 (Linux; U; Android 4.1.2; en-us; HUAWEI G610-C00 Build HuaweiG610-C00) UC AppleWebKit 534.31 (KHTML, like Gecko) Mobile Safari 534.31',
            ],
            [
                'Mozilla/5.0 (Linux; Android 11; moto g power (2022)) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36 Chrome-Lighthouse',
                'Mozilla/5.0 (Linux; Android 11; moto g power (2022)) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36 Chrome-Lighthouse',
            ],
            [
                'Mozilla/5.0 (Windows NT 10.0.16299.98; osmeta 10.3.3308) AppleWebKit/602.1.1 (KHTML, like Gecko) Version/9.0 Safari/602.1.1 osmeta/10.3.3308 Build/3308 [FBAN/FBW;FBAV/140.0.0.232.179;FBBV/83145113;FBDV/WindowsDevice;FBMD/Predator G9-793;FBSN/Windows;FBSV/10.0.16299.125;FBSS/1;FBCR/;FBID/desktop;FBLC/de_DE;FBOP/45;FBRV/0]',
                'Mozilla/5.0 (Windows NT 10.0.16299.98; osmeta 10.3.3308) AppleWebKit/602.1.1 (KHTML, like Gecko) Version/9.0 Safari/602.1.1 osmeta/10.3.3308 [FBAN/FBW;FBAV/140.0.0.232.179;FBBV/83145113;FBDV/WindowsDevice;FBMD/Predator G9-793;FBSN/Windows;FBSV/10.0.16299.125;FBSS/1;FBCR/;FBID/desktop;FBLC/de_DE;FBOP/45;FBRV/0]',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.4; de-de; novo7 Build/IML74K; CyanogenMod-9) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                'Mozilla/5.0 (Linux; U; Android 4.0.4; de-de; novo7; CyanogenMod-9) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
            ],
            [
                'Mozilla/5.0 (Linux; Android 14; A10 Build/UP1A.231105.001.A1; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/139.0.7258.94 Safari/537.36 GoogleApp/16.31.78.ve.arm64',
                'Mozilla/5.0 (Linux; Android 14; A10) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/139.0.7258.94 Safari/537.36 GoogleApp/16.31.78.ve.arm64',
            ],
            [
                'Kodi/14.2-RC1 (Linux; Android 4.4.3; KFTHWI Build/KTU84M) Android/4.4.3 Sys_CPU/armv7l App_Bitness/32 Version/14.2-RC1-Git:2015-03-11-e7ba06f-dirty',
                'Kodi/14.2-RC1 (Linux; Android 4.4.3; KFTHWI) Android/4.4.3 Sys_CPU/armv7l App_Bitness/32 Version/14.2-RC1-Git:2015-03-11-e7ba06f-dirty',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.2.1; AMOI N850 Build/JOP40D YunOS/2.1.0-E-20130906.0730) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/19.77.34.5 Mobile Safari/537.36 Tanggula/0.1.0',
                'Mozilla/5.0 (Linux; Android 4.2.1; AMOI N850 YunOS/2.1.0-E-20130906.0730) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/19.77.34.5 Mobile Safari/537.36 Tanggula/0.1.0',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 2.3.5; zh-cn; BIRD T900 Build/MocorDroid2.3.5) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1 baiduboxapp/061_2.7.3_diordna_084_023/drps_01_5.3.2_009T DRIB/7300043a/0B83D996383DD1C9ED5A6BC9BC4B0B7C|0',
                'Mozilla/5.0 (Linux; U; Android 2.3.5; zh-cn; BIRD T900 Build/MocorDroid2.3.5) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1 baiduboxapp/061_2.7.3_diordna_084_023/drps_01_5.3.2_009T DRIB/7300043a/0B83D996383DD1C9ED5A6BC9BC4B0B7C|0',
            ],
            [
                'Mozilla/5.0 (Linux; Android 9; meizu M10 Build/PPR1.180610.011; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/88.0.4324.93 Mobile Safari/537.36 YandexSearch/7.40 YandexSearchBrowser/7.40',
                'Mozilla/5.0 (Linux; Android 9; meizu M10) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/88.0.4324.93 Mobile Safari/537.36 YandexSearch/7.40 YandexSearchBrowser/7.40',
            ],
        ];
    }
}
