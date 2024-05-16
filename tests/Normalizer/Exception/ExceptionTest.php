<?php
/**
 * This file is part of the ua-normalizer package.
 *
 * Copyright (c) 2015-2024, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace UaNormalizerTest\Normalizer\Exception;

use PHPUnit\Framework\TestCase;
use UaNormalizer\Normalizer\Exception\Exception;

use function sprintf;

final class ExceptionTest extends TestCase
{
    /** @throws \PHPUnit\Framework\Exception */
    public function testThrow(): void
    {
        $userAgent = 'abc';

        $e = Exception::throw($userAgent);

        self::assertInstanceOf(Exception::class, $e);
        self::assertSame(
            sprintf('an error occurecd while normalizing useragent "%s"', $userAgent),
            $e->getMessage(),
        );
    }
}
