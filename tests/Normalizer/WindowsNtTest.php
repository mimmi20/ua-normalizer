<?php
/**
 * This file is part of the ua-normalizer package.
 *
 * Copyright (c) 2015-2021, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace UaNormalizerTest\Normalizer;

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;
use UaNormalizer\Normalizer\Exception;
use UaNormalizer\Normalizer\WindowsNt;

final class WindowsNtTest extends TestCase
{
    private WindowsNt $normalizer;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->normalizer = new WindowsNt();
    }

    /**
     * @throws Exception
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     *
     * @dataProvider userAgentsDataProvider
     */
    public function testShouldNormalizeTheWindowsNtToken(string $userAgent, string $expected): void
    {
        $found = $this->normalizer->normalize($userAgent);
        self::assertSame($expected, $found);
    }

    /**
     * @return array<int, array<int, string>>
     */
    public function userAgentsDataProvider(): array
    {
        return [
            [
                'Mozilla/4.0 (compatible; Lotus-Notes/6.0; Windows-NT)',
                'Mozilla/4.0 (compatible; Lotus-Notes/6.0; Windows NT)',
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
