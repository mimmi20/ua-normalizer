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

namespace UaNormalizer\Normalizer;

use function mb_substr_count;
use function str_replace;

/**
 * User Agent Normalizer - clean IIS Logging from user agent
 */
final class IISLogging implements NormalizerInterface
{
    /** @throws void */
    public function normalize(string $userAgent): string
    {
        // If there are no spaces in a UA and more than 2 plus symbols, the UA is likely affected by IIS style logging issues
        if (mb_substr_count($userAgent, ' ') === 0 && 2 < mb_substr_count($userAgent, '+')) {
            $userAgent = str_replace('+', ' ', $userAgent);
        }

        return $userAgent;
    }
}
