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
        ];
    }
}
