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

use PHPUnit\Framework\TestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;
use UaNormalizer\Normalizer\Exception;

use function sprintf;

final class ExceptionTest extends TestCase
{
    private const USER_AGENT = 'abc';

    /**
     * @throws \PHPUnit\Framework\Exception
     * @throws InvalidArgumentException
     */
    public function testThrow(): void
    {
        $e = Exception::throw(self::USER_AGENT);

        self::assertInstanceOf(Exception::class, $e);
        self::assertSame(sprintf('an error occurecd while normalizing useragent "%s"', self::USER_AGENT), $e->getMessage());
    }
}
