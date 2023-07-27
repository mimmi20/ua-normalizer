<?php
/**
 * This file is part of the ua-normalizer package.
 *
 * Copyright (c) 2015-2023, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace UaNormalizerTest\Normalizer;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaNormalizer\Normalizer\Exception;
use UaNormalizer\Normalizer\Mozilla;
use UaNormalizer\Normalizer\NormalizerChain;
use UaNormalizer\Normalizer\NormalizerInterface;

use function sprintf;

final class NormalizerChainTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    #[DataProvider('userAgentsDataProvider')]
    public function testNormalizeConstruct(string $userAgent, string $expected): void
    {
        $chain = new NormalizerChain([new Mozilla()]);

        self::assertSame(1, $chain->count());
        self::assertSame($expected, $chain->normalize($userAgent));
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    #[DataProvider('userAgentsDataProvider')]
    public function testNormalizeAdd(string $userAgent, string $expected): void
    {
        $chain = new NormalizerChain();
        $chain->add(new Mozilla());

        self::assertSame(1, $chain->count());

        self::assertSame($expected, $chain->normalize($userAgent));
    }

    /**
     * @throws Exception
     * @throws \PHPUnit\Framework\Exception
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[DataProvider('userAgentsDataProvider')]
    public function testNormalizeException(string $userAgent, string $expected): void
    {
        $normalizer = $this->getMockBuilder(NormalizerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $normalizer->expects(self::once())
            ->method('normalize')
            ->with($userAgent)
            ->willReturn(null);

        $chain = new NormalizerChain();
        $chain->add($normalizer);

        self::assertSame(1, $chain->count());

        $this->expectException(Exception::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage(
            sprintf('an error occurecd while normalizing useragent "%s"', $userAgent),
        );

        $chain->normalize($userAgent);
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
