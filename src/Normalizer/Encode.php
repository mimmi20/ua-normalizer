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

namespace UaNormalizer\Normalizer;

use Override;

use function mb_substr_count;
use function preg_replace;
use function str_replace;

/**
 * User Agent Normalizer - clean IIS Logging from user agent
 */
final class Encode implements NormalizerInterface
{
    /** @throws void */
    #[Override]
    public function normalize(string $userAgent): string
    {
        if (mb_substr_count($userAgent, ' 2F') > 0 && mb_substr_count($userAgent, ' 28') > 0) {
            $userAgent = str_replace(
                [' 2F', ' 28', ' 3B', ' 29', ' 2C', ' 2B'],
                ['/', '(', ';', ')', ',', '+'],
                $userAgent,
            );
        }

        if (mb_substr_count($userAgent, '%2F') > 0 && mb_substr_count($userAgent, '%28') > 0) {
            $userAgent = str_replace(
                ['%2F', '%28', '%3B', '%29', '%2C', '%2B'],
                ['/', '(', ';', ')', ',', '+'],
                $userAgent,
            );

            $userAgent = preg_replace('/\+(?!\+)/', ' ', $userAgent);
        }

        return str_replace('%20', ' ', (string) $userAgent);
    }
}
