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
use UaNormalizer\Normalizer\Spaces;

final class SpacesTest extends TestCase
{
    private Spaces $normalizer;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @throws void
     */
    #[Override]
    protected function setUp(): void
    {
        $this->normalizer = new Spaces();
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
                'Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.5;U; en-us) AppleWebKit/534.6 (KHTML,   like Gecko) wOSBrowser/234.83 Safari/534.6 Touchpad/1.0',
                'Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.5;U; en-us) AppleWebKit/534.6 (KHTML, like Gecko) wOSBrowser/234.83 Safari/534.6 Touchpad/1.0',
            ],
            [
                'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_5; de-de) AppleWebKit/534.15  (KHTML, like Gecko) Version/5.0.3 Safari/533.19.4',
                'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_5; de-de) AppleWebKit/534.15 (KHTML, like Gecko) Version/5.0.3 Safari/533.19.4',
            ],
            [
                'Mozilla/5.0  (Macintosh; U; Intel Mac OS X 10_6_5; de-de) AppleWebKit/534.15  (KHTML, like Gecko) Version/5.0.3 Safari/533.19.4',
                'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_5; de-de) AppleWebKit/534.15 (KHTML, like Gecko) Version/5.0.3 Safari/533.19.4',
            ],
            [
                'Mozilla/5.0  (Macintosh; U; Intel Mac OS X 10_6_5; de-de) AppleWebKit/534.15  (KHTML,  like Gecko) Version/5.0.3 Safari/533.19.4',
                'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_5; de-de) AppleWebKit/534.15 (KHTML, like Gecko) Version/5.0.3 Safari/533.19.4',
            ],
            [
                'Mozilla',
                'Mozilla',
            ],
            [
                'Mozilla/5.0\\xa0(iPhone\\xa0U\\xa0CPU like\\xa0Mac\\xa0OS X\\xa0en)\\xa0AppleWebKit/420+\\xa0(KHTML,\\xa0like\\xa0Gecko)Version/3.0\\xa0Mobile/1A543\\xa0Safari/419.3',
                'Mozilla/5.0 (iPhone U CPU like Mac OS X en) AppleWebKit/420+ (KHTML, like Gecko)Version/3.0 Mobile/1A543 Safari/419.3',
            ],
            [
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_3) AppleWebKit / 537.36(KHTML, like Gecko) Chrome / 64.0.3282.189 Safari / 537.36 Vivaldi / 1.95.1077.55',
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_3) AppleWebKit/537.36(KHTML, like Gecko) Chrome/64.0.3282.189 Safari/537.36 Vivaldi/1.95.1077.55',
            ],
        ];
    }
}
