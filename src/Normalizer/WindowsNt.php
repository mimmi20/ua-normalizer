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
 * User Agent Normalizer - normalizes/fixes the "Windows NT" token in user agent
 */
final class WindowsNt implements NormalizerInterface
{
    public function normalize(string $userAgent): ?string
    {
        return preg_replace('/windows[ \-]nt/i', 'Windows NT', $userAgent);
    }
}
