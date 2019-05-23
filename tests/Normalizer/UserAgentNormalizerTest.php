<?php
/**
 * This file is part of the ua-normalizer package.
 *
 * Copyright (c) 2015-2019, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace UaNormalizerTest\Normalizer;

use PHPUnit\Framework\TestCase;
use UaNormalizer\Normalizer\Mozilla;
use UaNormalizer\Normalizer\NormalizerChain;

final class UserAgentNormalizerTest extends TestCase
{
    /**
     * @dataProvider userAgentsDataProvider
     *
     * @param string $userAgent
     * @param string $expected
     *
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \UaNormalizer\Normalizer\Exception
     *
     * @return void
     */
    public function testNormalizeConstruct(string $userAgent, string $expected): void
    {
        $normalizer = new NormalizerChain([new Mozilla()]);

        static::assertSame(1, $normalizer->count());

        static::assertSame($expected, $normalizer->normalize($userAgent));
    }

    /**
     * @dataProvider userAgentsDataProvider
     *
     * @param string $userAgent
     * @param string $expected
     *
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \UaNormalizer\Normalizer\Exception
     *
     * @return void
     */
    public function testNormalizeAdd(string $userAgent, string $expected): void
    {
        $normalizer = new NormalizerChain([new Mozilla()]);

        static::assertSame(1, $normalizer->count());
        static::assertSame($expected, $normalizer->normalize($userAgent));
    }

    /**
     * @return array[]
     */
    public function userAgentsDataProvider()
    {
        return [
            [
                'Android (Linus; U; Android 1.5; zh-cn; hero) AppleWebKit/528.5+ (KHTML) Version/3.1.2',
                'Android (Linus; U; Android 1.5; zh-cn; hero) AppleWebKit/528.5+ (KHTML) Version/3.1.2',
            ],
            [
                'Android (Linux;  U; Android 1.5; zh-cn; hero) AppleWebKit/528.5+ (KHTML) Version/3.1.2',
                'Android (Linux;  U; Android 1.5; zh-cn; hero) AppleWebKit/528.5+ (KHTML) Version/3.1.2',
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
