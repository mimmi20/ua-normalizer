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

use function trim;

/**
 * User Agent Normalizer - removes leading and trailing spaces
 */
final class Trim implements NormalizerInterface
{
    /**
     * @return string Normalized user agent
     */
    public function normalize(string $userAgent): string
    {
        return trim($userAgent);
    }
}
