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
use UaNormalizer\Normalizer\RemoveShy;

final class RemoveShyTest extends TestCase
{
    private RemoveShy $normalizer;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @throws void
     */
    #[Override]
    protected function setUp(): void
    {
        $this->normalizer = new RemoveShy();
    }

    /** @throws ExpectationFailedException */
    #[DataProvider('userAgentsDataProvider')]
    public function testShouldRemoveShy(string $userAgent, string $expected): void
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
                'com.google.android.apps.searchlite/961535 (Linux; U; Android 13; de­_DE; 23028RN4DG; Build/TP1A.220624.014; Cronet/126.0.6423.0)',
                'com.google.android.apps.searchlite/961535 (Linux; U; Android 13; de_DE; 23028RN4DG; Build/TP1A.220624.014; Cronet/126.0.6423.0)',
            ],
            [
                'UCWEB/2.0 (Java; U; MIDP-2.0; Nokia203/20.37) U2/1.0.0 UCMini/10.9.8.1006 (SpeedMode; Proxy; Android 4.4.2; HTC­_Desire­_601­_dual­_sim ) U2/1.0.0 Mobile',
                'UCWEB/2.0 (Java; U; MIDP-2.0; Nokia203/20.37) U2/1.0.0 UCMini/10.9.8.1006 (SpeedMode; Proxy; Android 4.4.2; HTC_Desire_601_dual_sim ) U2/1.0.0 Mobile',
            ],
        ];
    }
}
