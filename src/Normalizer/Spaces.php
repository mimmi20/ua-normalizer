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

use function preg_replace;
use function str_replace;

/**
 * User Agent Normalizer - removes leading and trailing spaces
 */
final class Spaces implements NormalizerInterface
{
    /** @throws void */
    #[Override]
    public function normalize(string $userAgent): string
    {
        $userAgent = preg_replace('/\s+/', ' ', $userAgent);

        return str_replace('\xa0', ' ', (string) $userAgent);
    }
}
