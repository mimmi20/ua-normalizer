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
use UaNormalizer\Normalizer\LocaleRemover;

final class LocaleRemoverTest extends TestCase
{
    private LocaleRemover $normalizer;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @throws void
     */
    #[Override]
    protected function setUp(): void
    {
        $this->normalizer = new LocaleRemover();
    }

    /** @throws ExpectationFailedException */
    #[DataProvider('userAgentsDataProvider')]
    public function testShouldNormalizeTheLocale(string $userAgent, string $expected): void
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
                'Mozilla/5.0 (X11; U; Linux armv6l; en-US; rv:1.9a6pre) Gecko/20070810 Firefox/3.0a1',
                'Mozilla/5.0 (X11; U; Linux armv6l; rv:1.9a6pre) Gecko/20070810 Firefox/3.0a1',
            ],
            [
                'Mozilla/5.0 (SymbianOS/9.1; U; en-us) AppleWebKit/414 (KHTML, like Gecko) Safari/414 es61',
                'Mozilla/5.0 (SymbianOS/9.1; U) AppleWebKit/414 (KHTML, like Gecko) Safari/414 es61',
            ],
            [
                'Mozilla/5.0 (SymbianOS/9.1; U; en-us) AppleWebKit/413 (KHTML, like Gecko) Safari/413',
                'Mozilla/5.0 (SymbianOS/9.1; U) AppleWebKit/413 (KHTML, like Gecko) Safari/413',
            ],
            [
                'Android (Linux; U; Android 1.5; zh-cn; hero) AppleWebKit/528.5+ (KHTML) Version/3.1.2',
                'Android (Linux; U; Android 1.5; hero) AppleWebKit/528.5+ (KHTML) Version/3.1.2',
            ],
            [
                'HTC_Dream Mozilla/5.0 (Linux; U; Android 1.5; it-; Build/CRB43) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1',
                'HTC_Dream Mozilla/5.0 (Linux; U; Android 1.5; Build/CRB43) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 0.5; en-us) AppleWebKit/522+ (KHTML, like Gecko) Safari/419.3',
                'Mozilla/5.0 (Linux; U; Android 0.5) AppleWebKit/522+ (KHTML, like Gecko) Safari/419.3',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 0.6; en-us; generic) AppleWebKit/525.10+ (KHTML, like Gecko) Version/3.0.4 Mobile Safari/523.12.2',
                'Mozilla/5.0 (Linux; U; Android 0.6; generic) AppleWebKit/525.10+ (KHTML, like Gecko) Version/3.0.4 Mobile Safari/523.12.2',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 1.0; en-us; dream) AppleWebKit/525.10+ (KHTML, like Gecko) Version/3.0.4 Mobile Safari/523.12.2',
                'Mozilla/5.0 (Linux; U; Android 1.0; dream) AppleWebKit/525.10+ (KHTML, like Gecko) Version/3.0.4 Mobile Safari/523.12.2',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 1.1; en-us; generic) AppleWebKit/525.10+ (KHTML, like Gecko) Version/3.0.4 Mobile Safari/523.12.2',
                'Mozilla/5.0 (Linux; U; Android 1.1; generic) AppleWebKit/525.10+ (KHTML, like Gecko) Version/3.0.4 Mobile Safari/523.12.2',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android Blur_Version.0.6.13.morrison.Blurdev.en.US; en-us; generic) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1',
                'Mozilla/5.0 (Linux; U; Android Blur_Version.0.6.13.morrison.Blurdev.en.US; generic) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 1.5; de-de; HTC Magic Build/CRA86) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1',
                'Mozilla/5.0 (Linux; U; Android 1.5; HTC Magic Build/CRA86) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 1.5; en-gb; HTC Magic Build/CRA71C) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1',
                'Mozilla/5.0 (Linux; U; Android 1.5; HTC Magic Build/CRA71C) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 2.1-update1; de-de; HTC Hero Build/ERE27) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17',
                'Mozilla/5.0 (Linux; U; Android 2.1-update1; HTC Hero Build/ERE27) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17',
            ],
            [
                'Mozilla/5.0 (X11; U; Linux armv7l; en-GB; rv:1.9.2a1pre) Gecko/20090928 Firefox/3.5 Maemo Browser 1.4.1.21 RX-51 N900',
                'Mozilla/5.0 (X11; U; Linux armv7l; rv:1.9.2a1pre) Gecko/20090928 Firefox/3.5 Maemo Browser 1.4.1.21 RX-51 N900',
            ],
            [
                'Mozilla',
                'Mozilla',
            ],
            [
                'Firefox',
                'Firefox',
            ],
            [
                'Mozilla/5.0 (X11; U; Linux armv7l; en; rv:1.9.2a1pre) Gecko/20090928 Firefox/3.5 Maemo Browser 1.4.1.21 RX-51 N900',
                'Mozilla/5.0 (X11; U; Linux armv7l; rv:1.9.2a1pre) Gecko/20090928 Firefox/3.5 Maemo Browser 1.4.1.21 RX-51 N900',
            ],
            [
                'Mozilla/5.0 (X11; U; Linux armv7l;en; rv:1.9.2a1pre) Gecko/20090928 Firefox/3.5 Maemo Browser 1.4.1.21 RX-51 N900',
                'Mozilla/5.0 (X11; U; Linux armv7l; rv:1.9.2a1pre) Gecko/20090928 Firefox/3.5 Maemo Browser 1.4.1.21 RX-51 N900',
            ],
            [
                'Mozilla/5.0 (X11; U; Linux armv7l;en-us; rv:1.9.2a1pre) Gecko/20090928 Firefox/3.5 Maemo Browser 1.4.1.21 RX-51 N900',
                'Mozilla/5.0 (X11; U; Linux armv7l; rv:1.9.2a1pre) Gecko/20090928 Firefox/3.5 Maemo Browser 1.4.1.21 RX-51 N900',
            ],
            [
                'Mozilla/5.0 (X11; U; Linux armv7l; en_us; rv:1.9.2a1pre) Gecko/20090928 Firefox/3.5 Maemo Browser 1.4.1.21 RX-51 N900',
                'Mozilla/5.0 (X11; U; Linux armv7l; rv:1.9.2a1pre) Gecko/20090928 Firefox/3.5 Maemo Browser 1.4.1.21 RX-51 N900',
            ],
            [
                'Mozilla/5.0 (compatible; fr-crawler/1.1)',
                'Mozilla/5.0 (compatible; fr-crawler/1.1)',
            ],
            [
                'Mozilla/5.0 (compatible; ca-crawler/1.0)',
                'Mozilla/5.0 (compatible; ca-crawler/1.0)',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.1.1; es-es; bq Curie Build/1.1.0 20130322-14:50) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                'Mozilla/5.0 (Linux; U; Android 4.1.1; bq Curie Build/1.1.0 20130322-14:50) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.4; es-es; bq Edison Build/1.1.7 20121029-11:59) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                'Mozilla/5.0 (Linux; U; Android 4.0.4; bq Edison Build/1.1.7 20121029-11:59) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.2.2; bq Edison 2 Quad Core Build/1.2.0_20140106-13:59) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.114 Safari/537.36',
                'Mozilla/5.0 (Linux; Android 4.2.2; bq Edison 2 Quad Core Build/1.2.0_20140106-13:59) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.114 Safari/537.36',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.1.2; es-es; bq Elcano Build/JZO54K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                'Mozilla/5.0 (Linux; U; Android 4.1.2; bq Elcano Build/JZO54K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.4; en-us; bq Maxwell Plus Build/1.0.3 20121201-14:07) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                'Mozilla/5.0 (Linux; U; Android 4.0.4; bq Maxwell Plus Build/1.0.3 20121201-14:07) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
            ],
            [
                'Mozilla/5.0 (compatible; CA-crawler/1.0)',
                'Mozilla/5.0 (compatible; CA-crawler/1.0)',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 14; zh-Hans-CN; SM-F7410 Build/UP1A.231005.007) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/100.0.4896.58 Quark/7.11.0.810 Mobile Safari/537.36',
                'Mozilla/5.0 (Linux; U; Android 14; SM-F7410 Build/UP1A.231005.007) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/100.0.4896.58 Quark/7.11.0.810 Mobile Safari/537.36',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.1.2; ja-jp; SCL21 Build/JZO54K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'Mozilla/5.0 (Linux; U; Android 4.1.2; SCL21 Build/JZO54K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.2.2; es-es; GT-003 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'Mozilla/5.0 (Linux; U; Android 4.2.2; GT-003 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.2.2; xx; SM-V700 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'Mozilla/5.0 (Linux; U; Android 4.2.2; SM-V700 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.2.2; cs-es; GT-003 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'Mozilla/5.0 (Linux; U; Android 4.2.2; GT-003 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.2.2; el-es; GT-003 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'Mozilla/5.0 (Linux; U; Android 4.2.2; GT-003 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 13; ar-SA; SM-A536B Build/TP1A.220624.014) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.108 UCBrowser/13.4.0.1306 Mobile Safari/537.36',
                'Mozilla/5.0 (Linux; U; Android 13; SM-A536B Build/TP1A.220624.014) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.108 UCBrowser/13.4.0.1306 Mobile Safari/537.36',
            ],
        ];
    }
}
