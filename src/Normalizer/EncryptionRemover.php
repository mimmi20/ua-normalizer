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

namespace UaNormalizer\Normalizer;

use function preg_replace;
use function str_replace;

/**
 * User Agent Normalizer - removes encryption information from user agent
 */
final class EncryptionRemover implements NormalizerInterface
{
    /**
     * @throws Exception
     */
    public function normalize(string $userAgent): string
    {
        $userAgent  = str_replace('; UEAINT', '', $userAgent);
        $normalized = preg_replace('/; ?[IU];/', ';', $userAgent);

        if (null === $normalized) {
            throw Exception::throw($userAgent);
        }

        return $normalized;
    }
}
