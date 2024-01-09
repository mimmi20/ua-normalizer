<?php
/**
 * This file is part of the ua-normalizer package.
 *
 * Copyright (c) 2015-2024, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace UaNormalizerTest\Normalizer;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaNormalizer\Normalizer\Mozilla;

final class MozillaTest extends TestCase
{
    private Mozilla $normalizer;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @throws void
     */
    protected function setUp(): void
    {
        $this->normalizer = new Mozilla();
    }

    /** @throws ExpectationFailedException */
    #[DataProvider('userAgentsDataProvider')]
    public function testShouldNormalizeTheMozillaToken(string $userAgent, string $expected): void
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
                'Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.5; U; en-us) AppleWebKit/534.6 (KHTML, like Gecko) wOSBrowser/234.83 Safari/534.6 Touchpad/1.0',
                'Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.5; U; en-us) AppleWebKit/534.6 (KHTML, like Gecko) wOSBrowser/234.83 Safari/534.6 Touchpad/1.0',
            ],
            [
                'Mozzila/5.0 (hp-tablet; Linux; hpwOS/3.0.5;U; en-us) AppleWebKit/534.6 (KHTML, like Gecko) wOSBrowser/234.83 Safari/534.6 Touchpad/1.0',
                'Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.5;U; en-us) AppleWebKit/534.6 (KHTML, like Gecko) wOSBrowser/234.83 Safari/534.6 Touchpad/1.0',
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
                'Mozilla 5.0 (Linux; U; Android 4.1.2; en-us; HUAWEI G610-C00 Build HuaweiG610-C00) UC AppleWebKit 534.31 (KHTML, like Gecko) Mobile Safari 534.31',
                'Mozilla/5.0 (Linux; U; Android 4.1.2; en-us; HUAWEI G610-C00 Build HuaweiG610-C00) UC AppleWebKit 534.31 (KHTML, like Gecko) Mobile Safari 534.31',
            ],
        ];
    }
}
