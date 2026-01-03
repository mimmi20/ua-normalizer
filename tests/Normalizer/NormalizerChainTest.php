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
    #[DataProvider('userAgentsDataProvider')]
    public function testNormalizeConstruct(string $userAgent, string $expected): void
    {
        $chain = new NormalizerChain([new Mozilla()]);

        self::assertSame(1, $chain->count());
        self::assertSame($expected, $chain->normalize($userAgent));
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    #[DataProvider('userAgentsDataProvider')]
    public function testNormalizeAdd(string $userAgent, string $expected): void
    {
        $chain = new NormalizerChain();
        $chain->add(new Mozilla());

        self::assertSame(1, $chain->count());

        self::assertSame($expected, $chain->normalize($userAgent));
    }

    /**
     * @throws Exception
     * @throws \PHPUnit\Framework\Exception
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[DataProvider('userAgentsDataProvider')]
    public function testNormalizeException(string $userAgent, string $expected): void
    {
        $normalizer = $this->getMockBuilder(NormalizerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $normalizer->expects(self::once())
            ->method('normalize')
            ->with($userAgent)
            ->willReturn(null);

        $chain = new NormalizerChain();
        $chain->add($normalizer);

        self::assertSame(1, $chain->count());

        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage(
            sprintf('an error occurecd while normalizing useragent "%s"', $userAgent),
        );

        $chain->normalize($userAgent);
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
    #[DataProvider('userAgentsDataProviderComplete')]
    public function testNormalizeFromFactory(string $userAgent, string $expected): void
    {
        $chain = (new NormalizerFactory())->build();

        self::assertSame(17, $chain->count());
        self::assertSame($expected, $chain->normalize($userAgent));
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
                'HTC_Dream Mozilla/5.0 (Linux; Android 1.5; Build/CRB43) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1',
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
                'Mozilla/5.0 (Linux; Android 1.5; HTC Magic Build/CRA86) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 1.5; en-gb; HTC Magic Build/CRA71C) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1',
                'Mozilla/5.0 (Linux; Android 1.5; HTC Magic Build/CRA71C) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 2.1-update1; de-de; HTC Hero Build/ERE27) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17',
                'Mozilla/5.0 (Linux; Android 2.1-update1; HTC Hero Build/ERE27) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17',
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
                'Mozilla/5.0 (Linux; Android 4.1.1; bq Curie Build/1.1.0 20130322-14:50) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.4; es-es; bq Edison Build/1.1.7 20121029-11:59) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                'Mozilla/5.0 (Linux; Android 4.0.4; bq Edison Build/1.1.7 20121029-11:59) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.2.2; bq Edison 2 Quad Core Build/1.2.0_20140106-13:59) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.114 Safari/537.36',
                'Mozilla/5.0 (Linux; Android 4.2.2; bq Edison 2 Quad Core Build/1.2.0_20140106-13:59) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.114 Safari/537.36',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.1.2; es-es; bq Elcano Build/JZO54K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                'Mozilla/5.0 (Linux; Android 4.1.2; bq Elcano Build/JZO54K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.4; en-us; bq Maxwell Plus Build/1.0.3 20121201-14:07) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                'Mozilla/5.0 (Linux; Android 4.0.4; bq Maxwell Plus Build/1.0.3 20121201-14:07) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
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
                'Mozilla/5.0 (Linux; Android 12; Mi 10T Lite Build/SKQ1.211006.001) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/112.0.5615.136 Mobile Safari/537.36 XiaoMi/MiuiBrowser/13.33.0-gn',
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
                'Dalvik/1.6.0 (Linux; Android 4.2.2; Gigaset QV1030 Build/JDQ39)',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 14; zh-Hans-CN; SM-F7410 Build/UP1A.231005.007) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/100.0.4896.58 Quark/7.11.0.810 Mobile Safari/537.36',
                'Mozilla/5.0 (Linux; Android 14; SM-F7410 Build/UP1A.231005.007) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/100.0.4896.58 Quark/7.11.0.810 Mobile Safari/537.36',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.1.2; ja-jp; SCL21 Build/JZO54K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'Mozilla/5.0 (Linux; Android 4.1.2; SCL21 Build/JZO54K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
            ],
            [
                'Mozilla%2F5.0+%28Linux%3B+U%3B+Android+13%3B+de-de%3B+Redmi+Note+12+Pro%2B+5G+Build%2FTP1A.220624.014%29+AppleWebKit%2F537.36+%28KHTML%2C+like+Gecko%29+Version%2F4.0+Chrome%2F112.0.5615.136+Mobile+Safari%2F537.36+XiaoMi%2FMiuiBrowser%2F13.35.0-gn',
                'Mozilla/5.0 (Linux; Android 13; Redmi Note 12 Pro+ 5G Build/TP1A.220624.014) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/112.0.5615.136 Mobile Safari/537.36 XiaoMi/MiuiBrowser/13.35.0-gn',
            ],
            [
                'ozilla/5.0 (Linux; U; Android 4.1.2; en-us; HUAWEI G610-C00 Build HuaweiG610-C00) UC AppleWebKit 534.31 (KHTML, like Gecko) Mobile Safari 534.31',
                'Mozilla/5.0 (Linux; Android 4.1.2; HUAWEI G610-C00 Build HuaweiG610-C00) UC AppleWebKit 534.31 (KHTML, like Gecko) Mobile Safari 534.31',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.2.2; es-es; GT-003 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'Mozilla/5.0 (Linux; Android 4.2.2; GT-003 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.2.2; xx; SM-V700 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'Mozilla/5.0 (Linux; Android 4.2.2; SM-V700 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 13; ar-SA; SM-A536B Build/TP1A.220624.014) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.108 UCBrowser/13.4.0.1306 Mobile Safari/537.36',
                'Mozilla/5.0 (Linux; Android 13; SM-A536B Build/TP1A.220624.014) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.108 UCBrowser/13.4.0.1306 Mobile Safari/537.36',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.3; -; PP4MT-7 Build/IML74K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                'Mozilla/5.0 (Linux; Android 4.0.3; PP4MT-7 Build/IML74K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
            ],
            [
                'Mozilla/5.0 (iPad; CPU OS 12_1_4 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/12.0 WorxWeb/19.1.5(build 19.1.5.23)  Mobile/16D57 Safari/605.1<tabid-26FE0814-D13D-4710-A6EA-38E7A9B7866D>',
                'Mozilla/5.0 (iPad; CPU OS 12_1_4 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/12.0 WorxWeb/19.1.5(build 19.1.5.23) Mobile/16D57 Safari/605.1',
            ],
            [
                'Opera%20Touch/11 CFNetwork/1125.2 Darwin/19.4.0',
                'Opera Touch/11 CFNetwork/1125.2 Darwin/19.4.0',
            ],
        ];
    }
}
