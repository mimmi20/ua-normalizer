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

/**
 * User Agent Normalizer - removes hexcode garbage from user agent
 */
final class HexCode implements NormalizerInterface
{
    /** @throws void */
    #[Override]
    public function normalize(string $userAgent): string | null
    {
        return preg_replace('/([\\\]+)(x)([0-9a-f]{2})/i', '', $userAgent);
    }
}
