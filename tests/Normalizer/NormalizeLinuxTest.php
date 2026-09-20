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
use UaNormalizer\Normalizer\NormalizeLinux;

final class NormalizeLinuxTest extends TestCase
{
    private NormalizeLinux $normalizer;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @throws void
     */
    #[Override]
    protected function setUp(): void
    {
        $this->normalizer = new NormalizeLinux();
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
                'Android (Linus; U; Android 1.5; zh-cn; hero) AppleWebKit/528.5+ (KHTML) Version/3.1.2',
                'Android (Linux; U; Android 1.5; zh-cn; hero) AppleWebKit/528.5+ (KHTML) Version/3.1.2',
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
        ];
    }
}
