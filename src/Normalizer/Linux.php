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

/**
 * User Agent Normalizer - normalizes/fixes "Linux" token in user agent
 */
final class Linux implements NormalizerInterface
{
    /**
     * @return string Normalized user agent
     *
     * @throws Exception
     */
    public function normalize(string $userAgent): string
    {
        $normalized = preg_replace('/\(Linu[sx]; */', '(Linux; ', $userAgent);

        if (null === $normalized) {
            throw Exception::throw($userAgent);
        }

        return $normalized;
    }
}
