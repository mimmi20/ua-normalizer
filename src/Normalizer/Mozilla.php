<?php

/**
 * This file is part of the ua-normalizer package.
 *
 * Copyright (c) 2015-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace UaNormalizer\Normalizer;

use Override;

use function preg_replace;
use function str_starts_with;

/**
 * User Agent Normalizer - normalizes/fixes "Mozilla" token in user agent
 */
final class Mozilla implements NormalizerInterface
{
    /** @throws void */
    #[Override]
    public function normalize(string $userAgent): string | null
    {
        if (str_starts_with($userAgent, 'ozilla')) {
            $userAgent = 'M' . $userAgent;
        }

        return preg_replace('/Moz(il|zi)la[\/ ]([\d.]+) ?/', 'Mozilla/$2 ', $userAgent);
    }
}
