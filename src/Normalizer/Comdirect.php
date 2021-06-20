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

use function mb_stripos;
use function mb_substr;

/**
 * User Agent Normalizer - removes "comdirect/1.0 (appVersion:" token from user agent
 */
final class Comdirect implements NormalizerInterface
{
    public function normalize(string $userAgent): ?string
    {
        $pos = mb_stripos($userAgent, 'comdirect/');

        if (false === $pos) {
            return $userAgent;
        }

        return mb_substr($userAgent, 0, $pos - 1);
    }
}
