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

use UaNormalizer\Normalizer\Exception\Exception;

/**
 * User Agent Normalizer - generic interface for all normalizers
 */
interface NormalizerInterface
{
    /**
     * Return the normalized user agent
     *
     * @return string|null Normalized user agent
     *
     * @throws Exception
     */
    public function normalize(string $userAgent): string | null;
}
