<?php
/**
 * This file is part of the ua-normalizer package.
 *
 * Copyright (c) 2015-2020, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace UaNormalizer\Normalizer;

use function sprintf;

final class Exception extends \UnexpectedValueException
{
    /**
     * @param string $userAgent
     *
     * @return self
     */
    public static function throw(string $userAgent): self
    {
        $message = sprintf('an error occurecd while normalizing useragent "%s"', $userAgent);

        if (false === $message) {
            $message = 'an error occurecd while normalizing an useragent followed by an error while generating the exception message';
        }

        return new self($message);
    }
}
