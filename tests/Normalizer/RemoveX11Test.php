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
use UaNormalizer\Normalizer\RemoveX11;

final class RemoveX11Test extends TestCase
{
    private RemoveX11 $normalizer;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @throws void
     */
    #[Override]
    protected function setUp(): void
    {
        $this->normalizer = new RemoveX11();
    }

    /** @throws ExpectationFailedException */
    #[DataProvider(methodName: 'userAgentsDataProvider')]
    public function testShouldNormalizeTheLinuxToken(string $userAgent, string $expected): void
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
                'Mozilla/5.0 (Unknown; Linux x86_64) AppleWebKit/602.1 (KHTML, like Gecko) wkhtmltoimage Version/10.0 Safari/602.1',
                'Mozilla/5.0 (Linux x86_64) AppleWebKit/602.1 (KHTML, like Gecko) wkhtmltoimage Version/10.0 Safari/602.1',
            ],
            [
                'Mozilla/5.0 (X11; U; Linux x86_64; ru-RU) AppleWebKit/533.3 (KHTML, like Gecko) Leechcraft/0.4.55-13-g2230d9f Safari/533.3',
                'Mozilla/5.0 (X11; U; Linux x86_64; ru-RU) AppleWebKit/533.3 (KHTML, like Gecko) Leechcraft/0.4.55-13-g2230d9f Safari/533.3',
            ],
            [
                'Mozilla/5.0 (X11; Linux i686; rv:1.9.5.20) Gecko/2832-09-24 00:30:04.349823 Firefox/3.8',
                'Mozilla/5.0 (Linux i686; rv:1.9.5.20) Gecko/2832-09-24 00:30:04.349823 Firefox/3.8',
            ],
            [
                'Mozilla/5.0 (Wayland; Linux x86_64; Huawei) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.141 Safari/537.36 Ubuntu/22.04 (5.1.2567.73-1) Vivaldi/5.1.2567.73',
                'Mozilla/5.0 (Linux x86_64; Huawei) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.141 Safari/537.36 Ubuntu/22.04 (5.1.2567.73-1) Vivaldi/5.1.2567.73',
            ],
            [
                'Mozilla/5.0 (Linux; X11)',
                'Mozilla/5.0 (Linux)',
            ],
            [
                'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0',
                'Mozilla/5.0 (Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0',
            ],
            [
                'Mozilla/5.0 (X11; U; OpenBSD i386; en-US; rv:1.7.10) Gecko/20050919 (No IDN) Firefox/1.0.6',
                'Mozilla/5.0 (X11; U; OpenBSD i386; en-US; rv:1.7.10) Gecko/20050919 (No IDN) Firefox/1.0.6',
            ],
            [
                'Mozilla/5.0 (X11; Fedora; Linux x86_64; rv:97.0) Gecko/20100101 Firefox/97.0',
                'Mozilla/5.0 (Fedora; Linux x86_64; rv:97.0) Gecko/20100101 Firefox/97.0',
            ],
            [
                'Mozilla/5.0 (X11; U; x86_64 Linux; en_GB, en_US) AppleWebKit/533.3 (KHTML, like Gecko) Chrome/5.0.358.0 Safari/533.3',
                'Mozilla/5.0 (X11; U; x86_64 Linux; en_GB, en_US) AppleWebKit/533.3 (KHTML, like Gecko) Chrome/5.0.358.0 Safari/533.3',
            ],
            [
                'Mozilla/5.0 (X11; CrOS i686 4319.74.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.57 Safari/537.36',
                'Mozilla/5.0 (CrOS i686 4319.74.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.57 Safari/537.36',
            ],
            [
                'Mozilla/5.0 (X11; Debian; Linux; rv:136.0) Gecko/20161509 Firefox/136.0',
                'Mozilla/5.0 (Debian; Linux; rv:136.0) Gecko/20161509 Firefox/136.0',
            ],
            [
                'Mozilla/5.0 (X11; U; SunOS sun4u; en-US; rv:1.7.12) Gecko/20050922 Firefox/1.0.7',
                'Mozilla/5.0 (X11; U; SunOS sun4u; en-US; rv:1.7.12) Gecko/20050922 Firefox/1.0.7',
            ],
            [
                'Mozilla/5.0 (X11; FreeBSD amd64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36',
                'Mozilla/5.0 (FreeBSD amd64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36',
            ],
            [
                'mozilla/5.0 (x11; u; linux x86_64; en-us; rv:1.8.0.1) gecko/20060313 fedora/1.5.0.1-9 firefox/1.5.0.1 pango-text',
                'mozilla/5.0 (x11; u; linux x86_64; en-us; rv:1.8.0.1) gecko/20060313 fedora/1.5.0.1-9 firefox/1.5.0.1 pango-text',
            ],
            [
                'Mozilla/5.0 (X11 Linux i686) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1150.1  Iron/20.0.1150.1 Safari/536.11',
                'Mozilla/5.0 (Linux i686) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1150.1 Iron/20.0.1150.1 Safari/536.11',
            ],
            [
                'Mozilla/5.0 (X11; Intel Mac OS X) AppleWebKit/538.1 (KHTML, like Gecko) Safari/538.1 debian/unstable (3.8.2-5) Epiphany/3.8.2',
                'Mozilla/5.0 (Intel Mac OS X) AppleWebKit/538.1 (KHTML, like Gecko) Safari/538.1 debian/unstable (3.8.2-5) Epiphany/3.8.2',
            ],
            [
                'Mozilla/5.0 (X11; U; Gentoo x86_64; de-DE) Firefox/26.0',
                'Mozilla/5.0 (X11; U; Gentoo x86_64; de-DE) Firefox/26.0',
            ],
            [
                'NCSA_Mosaic/2.7b5 (X11;Linux 2.6.7 i686) libwww/2.12 modified',
                'NCSA_Mosaic/2.7b5 (Linux 2.6.7 i686) libwww/2.12 modified',
            ],
            [
                'Mozilla/5.0 (X11; U; NetBSD amd64; fr-FR; rv:1.8.0.7) Gecko/20061102 Firefox/1.5.0.7',
                'Mozilla/5.0 (X11; U; NetBSD amd64; fr-FR; rv:1.8.0.7) Gecko/20061102 Firefox/1.5.0.7',
            ],
            [
                'RSSOwl/2.2.1.201312301316 (X11; U; en)',
                'RSSOwl/2.2.1.201312301316 (X11; U; en)',
            ],
            [
                'Mozilla/5.0 (X11;) AppleWebKit/534.34 (KHTML, like Gecko) akregator/4.14.1 Safari/534.34',
                'Mozilla/5.0 AppleWebKit/534.34 (KHTML, like Gecko) akregator/4.14.1 Safari/534.34',
            ],
            [
                'Mozilla/5.0 (X11; ) AppleWebKit/534.24 (KHTML, like Gecko) Chrome/11.0.696.34 Safari/534.24',
                'Mozilla/5.0 (X11; ) AppleWebKit/534.24 (KHTML, like Gecko) Chrome/11.0.696.34 Safari/534.24',
            ],
            [
                'Mozilla/5.0 (X11; U; Win95; en-US; rv:1.8.1) Gecko/20061125 BonEcho/2.0',
                'Mozilla/5.0 (X11; U; Win95; en-US; rv:1.8.1) Gecko/20061125 BonEcho/2.0',
            ],
            [
                'Mozilla/5.0 (X11; U; DragonFly i386; de; rv:1.9.1) Gecko/20090720 Firefox/3.5.1',
                'Mozilla/5.0 (X11; U; DragonFly i386; de; rv:1.9.1) Gecko/20090720 Firefox/3.5.1',
            ],
        ];
    }
}
