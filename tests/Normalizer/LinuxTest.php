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
use UaNormalizer\Normalizer\Linux;

final class LinuxTest extends TestCase
{
    private Linux $normalizer;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->normalizer = new Linux();
    }

    /**
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     * @throws Exception
     *
     * @dataProvider userAgentsDataProvider
     */
    public function testShouldNormalizeTheLinuxToken(string $userAgent, string $expected): void
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
                'Android (Linus; U; Android 1.5; zh-cn; hero) AppleWebKit/528.5+ (KHTML) Version/3.1.2',
                'Android (Linux; U; Android 1.5; zh-cn; hero) AppleWebKit/528.5+ (KHTML) Version/3.1.2',
            ],
            [
                'Android (Linux;  U; Android 1.5; zh-cn; hero) AppleWebKit/528.5+ (KHTML) Version/3.1.2',
                'Android (Linux; U; Android 1.5; zh-cn; hero) AppleWebKit/528.5+ (KHTML) Version/3.1.2',
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
