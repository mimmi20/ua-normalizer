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

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\Normalizer\Mozilla;
use UaNormalizer\Normalizer\NormalizerChain;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaNormalizer\NormalizerFactory;

use function sprintf;

final class NormalizerChainTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    #[DataProvider(methodName: 'userAgentsDataProvider')]
    public function testNormalizeConstruct(string $userAgent, string $expected): void
    {
        $normalizerChain = new NormalizerChain([new Mozilla()]);

        self::assertSame(1, $normalizerChain->count());
        self::assertSame($expected, $normalizerChain->normalize($userAgent));
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    #[DataProvider(methodName: 'userAgentsDataProvider')]
    public function testNormalizeAdd(string $userAgent, string $expected): void
    {
        $normalizerChain = new NormalizerChain();
        $normalizerChain->add(new Mozilla());

        self::assertSame(1, $normalizerChain->count());

        self::assertSame($expected, $normalizerChain->normalize($userAgent));
    }

    /**
     * @throws Exception
     * @throws \PHPUnit\Framework\Exception
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[DataProvider(methodName: 'userAgentsDataProvider')]
    public function testNormalizeException(string $userAgent, string $expected): void
    {
        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer->expects(self::once())
            ->method('normalize')
            ->with($userAgent)
            ->willReturn(value: null);

        $normalizerChain = new NormalizerChain();
        $normalizerChain->add($normalizer);

        self::assertSame(1, $normalizerChain->count());

        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessageIsOrContains(
            sprintf('an error occurecd while normalizing useragent "%s"', $userAgent),
        );

        $normalizerChain->normalize($userAgent);
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
                'Android (Linus; U; Android 1.5; zh-cn; hero) AppleWebKit/528.5+ (KHTML) Version/3.1.2',
                'Android (Linus; U; Android 1.5; zh-cn; hero) AppleWebKit/528.5+ (KHTML) Version/3.1.2',
            ],
            [
                'Android (Linux;  U; Android 1.5; zh-cn; hero) AppleWebKit/528.5+ (KHTML) Version/3.1.2',
                'Android (Linux;  U; Android 1.5; zh-cn; hero) AppleWebKit/528.5+ (KHTML) Version/3.1.2',
            ],
            [
                'Mozilla',
                'Mozilla',
            ],
            [
                'Firefox',
                'Firefox',
            ],
        ];
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    #[DataProvider(methodName: 'userAgentsDataProviderComplete')]
    public function testNormalizeFromFactory(string $userAgent, string $expected): void
    {
        $normalizerChain = (new NormalizerFactory())->build();

        self::assertSame(22, $normalizerChain->count());
        self::assertSame($expected, $normalizerChain->normalize($userAgent));
    }

    /**
     * @return array<int, array<int, string>>
     *
     * @throws void
     */
    public static function userAgentsDataProviderComplete(): array
    {
        return [
            [
                'Android (Linus; U; Android 1.5; zh-cn; hero) AppleWebKit/528.5+ (KHTML) Version/3.1.2',
                'Android (Linux; Android 1.5; hero) AppleWebKit/528.5+ (KHTML) Version/3.1.2',
            ],
            [
                'Android (Linux;  U; Android 1.5; zh-cn; hero) AppleWebKit/528.5+ (KHTML) Version/3.1.2',
                'Android (Linux; Android 1.5; hero) AppleWebKit/528.5+ (KHTML) Version/3.1.2',
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
                'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1) Gecko/20090624 Firefox/3.5 (.NET CLR 3.5.30729) (via babelfish.yahoo.com)',
                'Mozilla/5.0 (Windows; Windows NT 5.1; rv:1.9.1) Gecko/20090624 Firefox/3.5 (.NET CLR 3.5.30729)',
            ],
            [
                'Mozilla/5.0+(compatible;+Googlebot/2.1;++http://www.google.com/bot.html) comdirect/1.0 (appVersion:19.11.0;deviceType:mobile)',
                'Mozilla/5.0 (compatible; Googlebot/2.1; http://www.google.com/bot.html)',
            ],
            [
                'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36 comdirect/1.0 (appVersion:19.6-FW-SNAPSHOT;deviceType:desktop)',
                'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36',
            ],
            [
                'Mozilla/5.0 (Linux; Android 9; Nokia 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.162 Mobile Safari/537.36 comdirect/1.0 (appVersion:20.3.0;deviceName:nokia 2;deviceType:mobile)',
                'Mozilla/5.0 (Linux; Android 9; Nokia 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.162 Mobile Safari/537.36',
            ],
            [
                'Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.5; U; en-us) AppleWebKit/534.6 (KHTML, like Gecko) wOSBrowser/234.83 Safari/534.6 Touchpad/1.0',
                'Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.5) AppleWebKit/534.6 (KHTML, like Gecko) wOSBrowser/234.83 Safari/534.6 Touchpad/1.0',
            ],
            [
                'Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.5; I; en-us) AppleWebKit/534.6 (KHTML, like Gecko) wOSBrowser/234.83 Safari/534.6 Touchpad/1.0',
                'Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.5) AppleWebKit/534.6 (KHTML, like Gecko) wOSBrowser/234.83 Safari/534.6 Touchpad/1.0',
            ],
            [
                'Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.5;U; en-us) AppleWebKit/534.6 (KHTML, like Gecko) wOSBrowser/234.83 Safari/534.6 Touchpad/1.0',
                'Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.5) AppleWebKit/534.6 (KHTML, like Gecko) wOSBrowser/234.83 Safari/534.6 Touchpad/1.0',
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; InfoPath.3;',
                'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; InfoPath.3;',
            ],
            [
                'Mozilla/5.0 (Windows NT 6.1; Win64; x64; Trident/7.0; UEAINT; rv:11.0) like Gecko',
                'Mozilla/5.0 (Windows NT 6.1; Win64; x64; Trident/7.0; rv:11.0) like Gecko',
            ],
            [
                'QuickTime\\\xaa.7.0.4 (qtver=7.0.4;cpu=PPC;os=Mac 10.3.9)',
                'QuickTime.7.0.4 (qtver=7.0.4;cpu=PPC;os=Mac 10.3.9)',
            ],
            [
                'QuickTime\xaa.7.0.4 (qtver=7.0.4;cpu=PPC=Mac 10.3.9)',
                'QuickTime.7.0.4 (qtver=7.0.4;cpu=PPC=Mac 10.3.9)',
            ],
            [
                'Mozilla/4.0+(compatible;+MSIE+7.0;+Windows+NT+5.1)',
                'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)',
            ],
            [
                'Mozilla/5.0 (compatible;WI Job Roboter Spider Version 3;+http://www.webintegration.at)',
                'Mozilla/5.0 (compatible;WI Job Roboter Spider Version 3;+http://www.webintegration.at)',
            ],
            [
                'Mozilla/4.0+(compatible;+Robot/1.0;zurukko640320919;)',
                'Mozilla/4.0 (compatible; Robot/1.0;zurukko640320919;)',
            ],
            [
                'Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.5; U; en-us) AppleWebKit/534.6 (HTML, like Gecko) wOSBrowser/234.83 Safari/534.6 Touchpad/1.0',
                'Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.5) AppleWebKit/534.6 (KHTML, like Gecko) wOSBrowser/234.83 Safari/534.6 Touchpad/1.0',
            ],
            [
                'Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.5;U; en-us) AppleWebKit/534.6 (KTHML, like Gecko) wOSBrowser/234.83 Safari/534.6 Touchpad/1.0',
                'Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.5) AppleWebKit/534.6 (KHTML, like Gecko) wOSBrowser/234.83 Safari/534.6 Touchpad/1.0',
            ],
            [
                'Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.5;U; en-us) AppleWebKit/534.6 (KHTML, like Gecko)    wOSBrowser/234.83 Safari/534.6 Touchpad/1.0',
                'Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.5) AppleWebKit/534.6 (KHTML, like Gecko) wOSBrowser/234.83 Safari/534.6 Touchpad/1.0',
            ],
            [
                'Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.5;U; en-us) AppleWebKit/534.6 (KHTML,   like Gecko) wOSBrowser/234.83 Safari/534.6 Touchpad/1.0',
                'Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.5) AppleWebKit/534.6 (KHTML, like Gecko) wOSBrowser/234.83 Safari/534.6 Touchpad/1.0',
            ],
            [
                'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_5; de-de) AppleWebKit/534.15  (KHTML, like Gecko) Version/5.0.3 Safari/533.19.4',
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_5) AppleWebKit/534.15 (KHTML, like Gecko) Version/5.0.3 Safari/533.19.4',
            ],
            [
                'Mozilla/5.0 (X11; U; Linux armv6l; en-US; rv:1.9a6pre) Gecko/20070810 Firefox/3.0a1',
                'Mozilla/5.0 (X11; Linux armv6l; rv:1.9a6pre) Gecko/20070810 Firefox/3.0a1',
            ],
            [
                'Mozilla/5.0 (SymbianOS/9.1; U; en-us) AppleWebKit/414 (KHTML, like Gecko) Safari/414 es61',
                'Mozilla/5.0 (SymbianOS/9.1) AppleWebKit/414 (KHTML, like Gecko) Safari/414 es61',
            ],
            [
                'Mozilla/5.0 (SymbianOS/9.1; U; en-us) AppleWebKit/413 (KHTML, like Gecko) Safari/413',
                'Mozilla/5.0 (SymbianOS/9.1) AppleWebKit/413 (KHTML, like Gecko) Safari/413',
            ],
            [
                'Android (Linux; U; Android 1.5; zh-cn; hero) AppleWebKit/528.5+ (KHTML) Version/3.1.2',
                'Android (Linux; Android 1.5; hero) AppleWebKit/528.5+ (KHTML) Version/3.1.2',
            ],
            [
                'HTC_Dream Mozilla/5.0 (Linux; U; Android 1.5; it-; Build/CRB43) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1',
                'HTC_Dream Mozilla/5.0 (Linux; Android 1.5) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 0.5; en-us) AppleWebKit/522+ (KHTML, like Gecko) Safari/419.3',
                'Mozilla/5.0 (Linux; Android 0.5) AppleWebKit/522+ (KHTML, like Gecko) Safari/419.3',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 0.6; en-us; generic) AppleWebKit/525.10+ (KHTML, like Gecko) Version/3.0.4 Mobile Safari/523.12.2',
                'Mozilla/5.0 (Linux; Android 0.6; generic) AppleWebKit/525.10+ (KHTML, like Gecko) Version/3.0.4 Mobile Safari/523.12.2',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 1.0; en-us; dream) AppleWebKit/525.10+ (KHTML, like Gecko) Version/3.0.4 Mobile Safari/523.12.2',
                'Mozilla/5.0 (Linux; Android 1.0; dream) AppleWebKit/525.10+ (KHTML, like Gecko) Version/3.0.4 Mobile Safari/523.12.2',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 1.1; en-us; generic) AppleWebKit/525.10+ (KHTML, like Gecko) Version/3.0.4 Mobile Safari/523.12.2',
                'Mozilla/5.0 (Linux; Android 1.1; generic) AppleWebKit/525.10+ (KHTML, like Gecko) Version/3.0.4 Mobile Safari/523.12.2',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android Blur_Version.0.6.13.morrison.Blurdev.en.US; en-us; generic) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1',
                'Mozilla/5.0 (Linux; Android Blur_Version.0.6.13.morrison.Blurdev.en.US; generic) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 1.5; de-de; HTC Magic Build/CRA86) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1',
                'Mozilla/5.0 (Linux; Android 1.5; HTC Magic) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 1.5; en-gb; HTC Magic Build/CRA71C) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1',
                'Mozilla/5.0 (Linux; Android 1.5; HTC Magic) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 2.1-update1; de-de; HTC Hero Build/ERE27) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17',
                'Mozilla/5.0 (Linux; Android 2.1-update1; HTC Hero) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17',
            ],
            [
                'Mozilla/5.0 (X11; U; Linux armv7l; en-GB; rv:1.9.2a1pre) Gecko/20090928 Firefox/3.5 Maemo Browser 1.4.1.21 RX-51 N900',
                'Mozilla/5.0 (X11; Linux armv7l; rv:1.9.2a1pre) Gecko/20090928 Firefox/3.5 Maemo Browser 1.4.1.21 RX-51 N900',
            ],
            [
                'Mozilla/5.0 (X11; U; Linux armv7l; en; rv:1.9.2a1pre) Gecko/20090928 Firefox/3.5 Maemo Browser 1.4.1.21 RX-51 N900',
                'Mozilla/5.0 (X11; Linux armv7l; rv:1.9.2a1pre) Gecko/20090928 Firefox/3.5 Maemo Browser 1.4.1.21 RX-51 N900',
            ],
            [
                'Mozilla/5.0 (X11; U; Linux armv7l;en; rv:1.9.2a1pre) Gecko/20090928 Firefox/3.5 Maemo Browser 1.4.1.21 RX-51 N900',
                'Mozilla/5.0 (X11; Linux armv7l; rv:1.9.2a1pre) Gecko/20090928 Firefox/3.5 Maemo Browser 1.4.1.21 RX-51 N900',
            ],
            [
                'Mozilla/5.0 (X11; U; Linux armv7l;en-us; rv:1.9.2a1pre) Gecko/20090928 Firefox/3.5 Maemo Browser 1.4.1.21 RX-51 N900',
                'Mozilla/5.0 (X11; Linux armv7l; rv:1.9.2a1pre) Gecko/20090928 Firefox/3.5 Maemo Browser 1.4.1.21 RX-51 N900',
            ],
            [
                'Mozilla/5.0 (X11; U; Linux armv7l; en_us; rv:1.9.2a1pre) Gecko/20090928 Firefox/3.5 Maemo Browser 1.4.1.21 RX-51 N900',
                'Mozilla/5.0 (X11; Linux armv7l; rv:1.9.2a1pre) Gecko/20090928 Firefox/3.5 Maemo Browser 1.4.1.21 RX-51 N900',
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
                'Mozilla/5.0 (Linux; Android 4.1.1; bq Curie) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.4; es-es; bq Edison Build/1.1.7 20121029-11:59) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                'Mozilla/5.0 (Linux; Android 4.0.4; bq Edison) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.2.2; bq Edison 2 Quad Core Build/1.2.0_20140106-13:59) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.114 Safari/537.36',
                'Mozilla/5.0 (Linux; Android 4.2.2; bq Edison 2 Quad Core) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.114 Safari/537.36',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.1.2; es-es; bq Elcano Build/JZO54K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                'Mozilla/5.0 (Linux; Android 4.1.2; bq Elcano) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.4; en-us; bq Maxwell Plus Build/1.0.3 20121201-14:07) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                'Mozilla/5.0 (Linux; Android 4.0.4; bq Maxwell Plus) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
            ],
            [
                'Mozilla/5.0 (compatible; CA-crawler/1.0)',
                'Mozilla/5.0 (compatible; CA-crawler/1.0)',
            ],
            [
                'Mozzila/5.0 (hp-tablet; Linux; hpwOS/3.0.5;U; en-us) AppleWebKit/534.6 (KHTML, like Gecko) wOSBrowser/234.83 Safari/534.6 Touchpad/1.0',
                'Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.5) AppleWebKit/534.6 (KHTML, like Gecko) wOSBrowser/234.83 Safari/534.6 Touchpad/1.0',
            ],
            [
                'r451[TFXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX] UP.Browser/6.2.3.8 (GUI) MMP/2.0',
                'r451 UP.Browser/6.2.3.8 (GUI) MMP/2.0',
            ],
            [
                'LG-LG1500[TF011231004305163000940013045946416] UP.Browser/6.2.3 (GUI) MMP/1.0 UP.Link/6.3.0.0.0',
                'LG-LG1500 UP.Browser/6.2.3 (GUI) MMP/1.0 UP.Link/6.3.0.0.0',
            ],
            [
                'MOT-V176/6.6.61[ST010913001046723002023302085980278] UP.Browser/6.2.3.9.c.9 (GUI) MMP/2.0 UP.Link/6.3.0.0.0',
                'MOT-V176/6.6.61 UP.Browser/6.2.3.9.c.9 (GUI) MMP/2.0 UP.Link/6.3.0.0.0',
            ],
            [
                'Vodafone/1.0/V702NK/NKJ001/IMEI/SN354350000005026 Series60/2.6 Nokia6630/2.40.235 Profile/MIDP-2.0 Configuration/CLDC-1.1',
                'Vodafone/1.0/V702NK/NKJ001/IMEI Series60/2.6 Nokia6630/2.40.235 Profile/MIDP-2.0 Configuration/CLDC-1.1',
            ],
            [
                'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0,gzip(gfe)',
                'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0',
            ],
            [
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) ',
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko)',
            ],
            [
                'Mozilla/4.0 (compatible; Lotus-Notes/6.0; Windows-NT)',
                'Mozilla/4.0 (compatible; Lotus-Notes/6.0; Windows NT)',
            ],
            [
                'Mozilla 2F5.0+ 28Linux 3B+U 3B+Android+12 3B+it-it 3B+Mi+10T+Lite+Build 2FSKQ1.211006.001 29+AppleWebKit 2F537.36+ 28KHTML 2C+like+Gecko 29+Version 2F4.0+Chrome 2F112.0.5615.136+Mobile+Safari 2F537.36+XiaoMi 2FMiuiBrowser 2F13.33.0-gn',
                'Mozilla/5.0 (Linux; Android 12; Mi 10T Lite) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/112.0.5615.136 Mobile Safari/537.36 XiaoMi/MiuiBrowser/13.33.0-gn',
            ],
            [
                'Mozilla/4.0 (compatible;+Robot/1.0;zurukko640320919;)',
                'Mozilla/4.0 (compatible;+Robot/1.0;zurukko640320919;)',
            ],
            [
                'Mozilla/5.0 (Linux; x86_64 GNU/Linux) AppleWebKit/601.1 (KHTML, like Gecko) Version/8.0 Safari/601.1 WPE ComcastAppPlatform AX061AEI Firebolt/0.8.1,gzip(gfe),gzip(gfe) 1.0.0.0 Xfinity',
                'Mozilla/5.0 (Linux; x86_64 GNU/Linux) AppleWebKit/601.1 (KHTML, like Gecko) Version/8.0 Safari/601.1 WPE ComcastAppPlatform AX061AEI Firebolt/0.8.1 1.0.0.0 Xfinity',
            ],
            [
                'Dalvik/1.6.0 (Linux## U## Android 4.2.2## Gigaset QV1030 Build/JDQ39)',
                'Dalvik/1.6.0 (Linux; Android 4.2.2; Gigaset QV1030)',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 14; zh-Hans-CN; SM-F7410 Build/UP1A.231005.007) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/100.0.4896.58 Quark/7.11.0.810 Mobile Safari/537.36',
                'Mozilla/5.0 (Linux; Android 14; SM-F7410) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/100.0.4896.58 Quark/7.11.0.810 Mobile Safari/537.36',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.1.2; ja-jp; SCL21 Build/JZO54K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'Mozilla/5.0 (Linux; Android 4.1.2; SCL21) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
            ],
            [
                'Mozilla%2F5.0+%28Linux%3B+U%3B+Android+13%3B+de-de%3B+Redmi+Note+12+Pro%2B+5G+Build%2FTP1A.220624.014%29+AppleWebKit%2F537.36+%28KHTML%2C+like+Gecko%29+Version%2F4.0+Chrome%2F112.0.5615.136+Mobile+Safari%2F537.36+XiaoMi%2FMiuiBrowser%2F13.35.0-gn',
                'Mozilla/5.0 (Linux; Android 13; Redmi Note 12 Pro+ 5G) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/112.0.5615.136 Mobile Safari/537.36 XiaoMi/MiuiBrowser/13.35.0-gn',
            ],
            [
                'ozilla/5.0 (Linux; U; Android 4.1.2; en-us; HUAWEI G610-C00 Build HuaweiG610-C00) UC AppleWebKit 534.31 (KHTML, like Gecko) Mobile Safari 534.31',
                'Mozilla/5.0 (Linux; Android 4.1.2; HUAWEI G610-C00 Build HuaweiG610-C00) UC AppleWebKit 534.31 (KHTML, like Gecko) Mobile Safari 534.31',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.2.2; es-es; GT-003 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'Mozilla/5.0 (Linux; Android 4.2.2; GT-003) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.2.2; xx; SM-V700 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'Mozilla/5.0 (Linux; Android 4.2.2; SM-V700) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 13; ar-SA; SM-A536B Build/TP1A.220624.014) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.108 UCBrowser/13.4.0.1306 Mobile Safari/537.36',
                'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.108 UCBrowser/13.4.0.1306 Mobile Safari/537.36',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.3; -; PP4MT-7 Build/IML74K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                'Mozilla/5.0 (Linux; Android 4.0.3; PP4MT-7) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
            ],
            [
                'Mozilla/5.0 (iPad; CPU OS 12_1_4 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/12.0 WorxWeb/19.1.5(build 19.1.5.23)  Mobile/16D57 Safari/605.1<tabid-26FE0814-D13D-4710-A6EA-38E7A9B7866D>',
                'Mozilla/5.0 (iPad; CPU OS 12_1_4 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/12.0 WorxWeb/19.1.5(build 19.1.5.23) Mobile/16D57 Safari/605.1',
            ],
            [
                'Opera%20Touch/11 CFNetwork/1125.2 Darwin/19.4.0',
                'Opera Touch/11 CFNetwork/1125.2 Darwin/19.4.0',
            ],
            [
                'com.google.android.apps.searchlite/961535 (Linux; U; Android 13; de­_DE; 23028RN4DG; Build/TP1A.220624.014; Cronet/126.0.6423.0)',
                'com.google.android.apps.searchlite/961535 (Linux; Android 13; 23028RN4DG; Cronet/126.0.6423.0)',
            ],
            [
                'UCWEB/2.0 (Java; U; MIDP-2.0; Nokia203/20.37) U2/1.0.0 UCMini/10.9.8.1006 (SpeedMode; Proxy; Android 4.4.2; HTC­_Desire­_601­_dual­_sim ) U2/1.0.0 Mobile',
                'UCWEB/2.0 (Java; MIDP-2.0; Nokia203/20.37) U2/1.0.0 UCMini/10.9.8.1006 (SpeedMode; Proxy; Android 4.4.2; HTC_Desire_601_dual_sim ) U2/1.0.0 Mobile',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 11; uk-ua; Redmi Note 10 Pro Build/RKQ1.200826.002) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/89.0.4389.116 Mobile Safari/537.36 XiaoMi/MiuiBrowser/12.13.0-gn',
                'Mozilla/5.0 (Linux; Android 11; Redmi Note 10 Pro) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/89.0.4389.116 Mobile Safari/537.36 XiaoMi/MiuiBrowser/12.13.0-gn',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 10; fa-ir; Redmi Note 8 Pro Build/QP1A.190711.020) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/71.0.3578.141 Mobile Safari/537.36 XiaoMi/MiuiBrowser/12.4.1-g',
                'Mozilla/5.0 (Linux; Android 10; Redmi Note 8 Pro) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/71.0.3578.141 Mobile Safari/537.36 XiaoMi/MiuiBrowser/12.4.1-g',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 9; ko-kr; Redmi Note 8 Build/PKQ1.190616.001) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/71.0.3578.141 Mobile Safari/537.36 XiaoMi/MiuiBrowser/12.6.2-gn comdirect/1.0 (appVersion:20.9.4;deviceName:nokia 8;deviceType:mobile)',
                'Mozilla/5.0 (Linux; Android 9; Redmi Note 8) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/71.0.3578.141 Mobile Safari/537.36 XiaoMi/MiuiBrowser/12.6.2-gn',
            ],
            [
                'AI%C2%A0Chat/1742 CFNetwork/1496.0.7 Darwin/23.5.0',
                'AI Chat/1742 CFNetwork/1496.0.7 Darwin/23.5.0',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.2.2; es-41; KFSOWI Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                'Mozilla/5.0 (Linux; Android 4.2.2; KFSOWI) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
            ],
            [
                'Mozilla/5.0 (Linux; Anroid 7.1.2; Redmi 4A Build/N2G47H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.84 Mobile Safari/537.36',
                'Mozilla/5.0 (Linux; Android 7.1.2; Redmi 4A) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.84 Mobile Safari/537.36',
            ],
            [
                'Mozilla/5.0 (Linux; Andriod 4.4.4 SM-G990V Build/KTU84P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.95 Mobile Safari/537.36',
                'Mozilla/5.0 (Linux; Android 4.4.4 SM-G990V) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.95 Mobile Safari/537.36',
            ],
            [
                'Mozilla/5.0 (Linux; diordnA 9; HiSmartTV A4 Build/PTMR.190127.037; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/99.100.4844.73 eliboM Safari/537.36 Quick Search TV/22.03.14',
                'Mozilla/5.0 (Linux; Android 9; HiSmartTV A4) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/99.100.4844.73 eliboM Safari/537.36 Quick Search TV/22.03.14',
            ],
            [
                'Mozilla/5.0/**/(Windows/**/NT/**/10.0;/**/Win64;/**/x64)/**/AppleWebKit/537.36/**/(KHTML,/**/like/**/Gecko)/**/Chrome/146.0.0.0/**/Safari/537.36";WAITFOR DELAY \'0:0:5\'--',
                'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36";WAITFOR DELAY \'0:0:5\'--',
            ],
            [
                '%4D%6F%7A%69%6C%6C%61%2F%35%2E%30%2F%2A%2A%2F%28%57%69%6E%64%6F%77%73%2F%2A%2A%2F%4E%54%2F%2A%2A%2F%31%30%2E%30%3B%2F%2A%2A%2F%57%69%6E%36%34%3B%2F%2A%2A%2F%78%36%34%29%2F%2A%2A%2F%41%70%70%6C%65%57%65%62%4B%69%74%2F%35%33%37%2E%33%36%2F%2A%2A%2F%28%4B%48%54%4D%4C%2C%2F%2A%2A%2F%4C%69%6B%45%2F%2A%2A%2F%47%65%63%6B%6F%29%2F%2A%2A%2F%43%68%72%6F%6D%65%2F%31%34%36%2E%30%2E%30%2E%30%2F%2A%2A%2F%53%61%66%61%72%69%2F%35%33%37%2E%33%36%22%3B%57%41%49%54%46%4F%52%20%44%45%4C%41%59%20%27%30%3A%30%3A%35%27%2D%2D',
                'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, LikE Gecko) Chrome/146.0.0.0 Safari/537.36";WAITFOR DELAY \'0:0:5\'--',
            ],
            [
                'Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 4 rev: 1812 Mobile Safari/533.3',
                'Mozilla/5.0 (QtEmbedded; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 4 rev: 1812 Mobile Safari/533.3',
            ],
            [
                'Opera/9.47.(Windows CE; km-KH) Presto/2.9.173 Version/10.00',
                'Opera/9.47.(Windows CE) Presto/2.9.173 Version/10.00',
            ],
            [
                'Mozilla/5.0\\xa0(iPhone\\xa0U\\xa0CPU like\\xa0Mac\\xa0OS X\\xa0en)\\xa0AppleWebKit/420+\\xa0(KHTML,\\xa0like\\xa0Gecko)Version/3.0\\xa0Mobile/1A543\\xa0Safari/419.3',
                'Mozilla/5.0 (iPhone U CPU like Mac OS X en) AppleWebKit/420+ (KHTML, like Gecko) Version/3.0 Mobile/1A543 Safari/419.3',
            ],
            [
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_3) AppleWebKit / 537.36(KHTML, like Gecko) Chrome / 64.0.3282.189 Safari / 537.36 Vivaldi / 1.95.1077.55',
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.189 Safari/537.36 Vivaldi/1.95.1077.55',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.4.3; es-419; KFASWI Build/KTU84M) AppleWebKit/537.36 (KHTML, like Gecko) Silk/3.47 like Chrome/37.0.2026.117 Safari/537.36',
                'Mozilla/5.0 (Linux; Android 4.4.3; KFASWI) AppleWebKit/537.36 (KHTML, like Gecko) Silk/3.47 like Chrome/37.0.2026.117 Safari/537.36',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 12; zh-Hans-DZ; LIO-AN00m Build/HUAWEILIO-AN00m) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/100.0.4896.58 Quark/6.2.8.250 Mobile Safari/537.36',
                'Mozilla/5.0 (Linux; Android 12; LIO-AN00m) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/100.0.4896.58 Quark/6.2.8.250 Mobile Safari/537.36',
            ],
            [
                'com.ss.android.article.news/8050 (Linux; U; Android 10; zh_CN_#Hans; OCE-AN10; Build/HUAWEIOCE-AN10; Cronet/TTNetVersion:1c8b77ac 2020-12-16 QuicVersion:47946d2a 2020-10-14)',
                'com.ss.android.article.news/8050 (Linux; Android 10; OCE-AN10; Cronet/TTNetVersion:1c8b77ac 2020-12-16 QuicVersion:47946d2a 2020-10-14)',
            ],
            [
                'UCWEB/2.0 (Java; U; MIDP-2.0; Pt-BR; maui e800) U2/1.0.0 UCBrowser/9.2.0.311 U2/1.0.0 Mobile UNTRUSTED/1.0',
                'UCWEB/2.0 (Java; MIDP-2.0; maui e800) U2/1.0.0 UCBrowser/9.2.0.311 U2/1.0.0 Mobile UNTRUSTED/1.0',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 16; hi-in; CPH2751 Build/BP2A.250605.015) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.5970.168 Mobile Safari/537.36 HeyTapBrowser/45.14.3.1',
                'Mozilla/5.0 (Linux; Android 16; CPH2751) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.5970.168 Mobile Safari/537.36 HeyTapBrowser/45.14.3.1',
            ],
            [
                'Mozilla/5.0 (Linux; Android 13; TECNO TECNO KJ6; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/149.0.7827.91 Mobile Safari/537.36 Sapphire/1.11.1',
                'Mozilla/5.0 (Linux; Android 13; TECNO KJ6; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/149.0.7827.91 Mobile Safari/537.36 Sapphire/1.11.1',
            ],
            [
                'Mozilla/5.0 (Linux; Android 13; TECNO Mobile KJ6; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/149.0.7827.91 Mobile Safari/537.36 Sapphire/1.11.1',
                'Mozilla/5.0 (Linux; Android 13; TECNO KJ6; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/149.0.7827.91 Mobile Safari/537.36 Sapphire/1.11.1',
            ],
            [
                'Mozilla/5.0 (Linux; Android 11; TECNO MOBILE LIMITED TECNO KG5n; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/149.0.7827.91 Mobile Safari/537.36 Sapphire/1.11.1',
                'Mozilla/5.0 (Linux; Android 11; TECNO KG5n; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/149.0.7827.91 Mobile Safari/537.36 Sapphire/1.11.1',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 14; zh-CN; MZ-MEIZU 20 Inf Build/MRA58K) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/73.0.3683.121 MZBrowser/11.0.5 Mobile Safari/537.36',
                'Mozilla/5.0 (Linux; Android 14; MEIZU 20 Inf) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/73.0.3683.121 MZBrowser/11.0.5 Mobile Safari/537.36',
            ],
            [
                'Mozilla/5.0 (Linux; Android 13; motorola edge 20-109-9-1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.7827.93 Mobile Safari/537.36',
                'Mozilla/5.0 (Linux; Android 13; motorola edge 20) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.7827.93 Mobile Safari/537.36',
            ],
            [
                'Mozilla/5.0 (Linux; Android 13; moto g72-21-10-21) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.7827.91 Mobile Safari/537.36',
                'Mozilla/5.0 (Linux; Android 13; moto g72) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.7827.91 Mobile Safari/537.36',
            ],
            [
                'Mozilla/5.0 (Linux; Android 14; moto e15 Build/UUTB34.40-36; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/141.0.7390.97 Mobile Safari/537.36 NSTNWV/3.129.815524762.31release.go',
                'Mozilla/5.0 (Linux; Android 14; moto e15) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/141.0.7390.97 Mobile Safari/537.36 NSTNWV/3.129.815524762.31release.go',
            ],
            [
                'NRC Audio/2.0.0 (nl.nrc.audio; build:29; Android 12; Sdk:31; Manufacturer:samsung; Model: SM-G975F) OkHttp/4.9.3',
                'NRC Audio/2.0.0 (nl.nrc.audio; build:29; Android 12; Sdk:31; Manufacturer:samsung; Model: SM-G975F) OkHttp/4.9.3',
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
                'Mozilla/5.0 (Linux; Android 4.0.4; novo7; CyanogenMod-9) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
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
                'Mozilla/5.0 (Linux; Android 2.3.5; BIRD T900 Build/MocorDroid2.3.5) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1 baiduboxapp/061_2.7.3_diordna_084_023/drps_01_5.3.2_009T DRIB/7300043a/0B83D996383DD1C9ED5A6BC9BC4B0B7C|0',
            ],
            [
                'Mozilla/5.0 (Linux; Android 9; meizu M10 Build/PPR1.180610.011; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/88.0.4324.93 Mobile Safari/537.36 YandexSearch/7.40 YandexSearchBrowser/7.40',
                'Mozilla/5.0 (Linux; Android 9; meizu M10) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/88.0.4324.93 Mobile Safari/537.36 YandexSearch/7.40 YandexSearchBrowser/7.40',
            ],
            [
                'Mozilla/5.0 (Linux; Android 13; moto g stylus 5G - 2023 Build/T1TGN33.60-55; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/132.0.6834.163 Mobile Safari/537.36',
                'Mozilla/5.0 (Linux; Android 13; moto g stylus 5G - 2023) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/132.0.6834.163 Mobile Safari/537.36',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 2.3.4; %lang2%; Kindle Fire Build/GINGERBREAD) adbeat.com/policy AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
                'Mozilla/5.0 (Linux; Android 2.3.4; Kindle Fire) adbeat.com/policy AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 13; octopus Build/R148-16640.61.0; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/148.0.7778.225 Safari/537.36 OPR/99.3.2254.1107',
                'Mozilla/5.0 (Linux; Android 13; octopus Build/R148-16640.61.0; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/148.0.7778.225 Safari/537.36 OPR/99.3.2254.1107',
            ],
            [
                'Dalvik/2.1.0 (Linux; U; Android 14; Z2450 Build/MyOS14.0.17_Z2450_EEA)',
                'Dalvik/2.1.0 (Linux; Android 14; Z2450 Build/MyOS14.0.17_Z2450_EEA)',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.4.2; he-il; GT-P5210 Build/KOT49H) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                'Mozilla/5.0 (Linux; Android 4.4.2; GT-P5210) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.3; de-1; GT-I9300 Build/JSS15J) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'Mozilla/5.0 (Linux; Android 4.3; GT-I9300) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.4; da-dk; DEOX Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                'Mozilla/5.0 (Linux; Android 4.0.4; DEOX) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; ru; ASUS_T00J) U2/1.0.0 UCBrowser/8.9.2.373 Mobile',
                'UCWEB/2.0 (Linux; Opera Mini/7.1.32052/30.3697; ASUS_T00J) U2/1.0.0 UCBrowser/8.9.2.373 Mobile',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.4; de-de, SmartTabII7 Build/A2107A_A404_107_055_130124_VODA) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                'Mozilla/5.0 (Linux; Android 4.0.4; SmartTabII7) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 5.0; nb-no; LG-D855 Build/LRX21R.A1421650137) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/34.0.1847.118 Mobile Safari/537.36',
                'Mozilla/5.0 (Linux; Android 5.0; LG-D855) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/34.0.1847.118 Mobile Safari/537.36',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.4.2; ka-ge; GT-N8000 Build/KOT49H) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                'Mozilla/5.0 (Linux; Android 4.4.2; GT-N8000) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.2; xx-xx; GT-I9500 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'Mozilla/5.0 (Linux; Android 4.2; GT-I9500) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
            ],
        ];
    }
}
