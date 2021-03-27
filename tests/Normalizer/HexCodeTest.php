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
use UaNormalizer\Normalizer\HexCode;

final class HexCodeTest extends TestCase
{
    private HexCode $normalizer;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->normalizer = new HexCode();
    }

    /**
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     * @throws Exception
     *
     * @dataProvider userAgentsDataProvider
     */
    public function testShouldNormalizeTheHexCodeToken(string $userAgent, string $expected): void
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
                'QuickTime\\\\xaa.7.0.4 (qtver=7.0.4;cpu=PPC;os=Mac 10.3.9)',
                'QuickTime.7.0.4 (qtver=7.0.4;cpu=PPC;os=Mac 10.3.9)',
            ],
            [
                'QuickTime\\xaa.7.0.4 (qtver=7.0.4;cpu=PPC=Mac 10.3.9)',
                'QuickTime.7.0.4 (qtver=7.0.4;cpu=PPC=Mac 10.3.9)',
            ],
            [
                'QuickTime.7.6.6',
                'QuickTime.7.6.6',
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
