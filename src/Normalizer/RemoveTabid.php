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
 * User Agent Normalizer - removes encryption information from user agent
 */
final class RemoveTabid implements NormalizerInterface
{
    /** @throws void */
    #[Override]
    public function normalize(string $userAgent): string | null
    {
        return preg_replace('/<tabid([0-9A-Z\-]+)>/', '', $userAgent);
    }
}
