<?php
/**
 * This file is part of the ua-normalizer package.
 *
 * Copyright (c) 2015-2019, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace UaNormalizer\Normalizer;

use function str_replace;

/**
 * User Agent Normalizer - removes transfer encoding information from user agent
 */
final class TransferEncoding implements NormalizerInterface
{
    /**
     * @param string $userAgent
     *
     * @return string
     */
    public function normalize(string $userAgent): string
    {
        return str_replace(',gzip(gfe)', '', $userAgent);
    }
}
