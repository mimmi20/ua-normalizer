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
use UaNormalizer\Normalizer\Comment;

final class CommentTest extends TestCase
{
    private Comment $normalizer;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @throws void
     */
    #[Override]
    protected function setUp(): void
    {
        $this->normalizer = new Comment();
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
                'Mozilla/5.0/**/(Windows/**/NT/**/10.0;/**/Win64;/**/x64)/**/AppleWebKit/537.36/**/(KHTML,/**/like/**/Gecko)/**/Chrome/146.0.0.0/**/Safari/537.36";WAITFOR DELAY \'0:0:5\'--',
                'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36";WAITFOR DELAY \'0:0:5\'--',
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
}
