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

namespace UaNormalizer\Normalizer;

use function mb_stripos;
use function mb_substr;
use function str_contains;

/**
 * User Agent Normalizer - removes "comdirect/1.0 (appVersion:" token from user agent
 */
final class Comdirect implements NormalizerInterface
{
    /** @throws void */
    public function normalize(string $userAgent): string
    {
        if (!str_contains($userAgent, 'comdirect/')) {
            return $userAgent;
        }

        $pos = mb_stripos($userAgent, 'comdirect/');

        return mb_substr($userAgent, 0, $pos - 1);
    }
}
