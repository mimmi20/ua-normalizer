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
 * User Agent Normalizer - removes BabelFish garbage from user agent
 */
final class BabelFish implements NormalizerInterface
{
    /**
     * @throws Exception
     */
    public function normalize(string $userAgent): string
    {
        $normalized = preg_replace('/\s*\(via babelfish.yahoo.com\)\s*/', '', $userAgent);

        if (null === $normalized) {
            throw Exception::throw($userAgent);
        }

        return $normalized;
    }
}
