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
use UaNormalizer\Normalizer\Android;

final class AndroidTest extends TestCase
{
    private Android $normalizer;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @throws void
     */
    #[Override]
    protected function setUp(): void
    {
        $this->normalizer = new Android();
    }

    /** @throws ExpectationFailedException */
    #[DataProvider('userAgentsDataProvider')]
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
                'Mozilla/5.0 (Linux; Anroid 7.1.2; Redmi 4A Build/N2G47H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.84 Mobile Safari/537.36',
                'Mozilla/5.0 (Linux; Android 7.1.2; Redmi 4A Build/N2G47H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.84 Mobile Safari/537.36',
            ],
            [
                'Mozilla/5.0 (Linux; Andriod 4.4.4 SM-G990V Build/KTU84P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.95 Mobile Safari/537.36',
                'Mozilla/5.0 (Linux; Android 4.4.4 SM-G990V Build/KTU84P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.95 Mobile Safari/537.36',
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
                'Mozilla/5.0 (Linux; Andr0id 11; Regal G00gle TV) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.120 Safari/537.36 OMI/4.25.1.92.StableAVB.5',
                'Mozilla/5.0 (Linux; Android 11; Regal G00gle TV) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.120 Safari/537.36 OMI/4.25.1.92.StableAVB.5',
            ],
        ];
    }
}
