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
use UaNormalizer\Normalizer\NormalizeBrandNames;

final class NormalizeBrandNamesTest extends TestCase
{
    private NormalizeBrandNames $normalizer;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @throws void
     */
    #[Override]
    protected function setUp(): void
    {
        $this->normalizer = new NormalizeBrandNames();
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
                'Mozilla/5.0 (Linux; U; Android 14; zh-CN; MEIZU 20 Inf Build/MRA58K) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/73.0.3683.121 MZBrowser/11.0.5 Mobile Safari/537.36',
            ],
        ];
    }
}
