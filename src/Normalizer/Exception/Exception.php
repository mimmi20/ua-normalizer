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

namespace UaNormalizer\Normalizer\Exception;

use UnexpectedValueException;

use function sprintf;

final class Exception extends UnexpectedValueException
{
    /** @throws void */
    public static function throw(string $userAgent): self
    {
        return new self(
            sprintf('an error occurecd while normalizing useragent "%s"', $userAgent),
        );
    }
}
