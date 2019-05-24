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

use function preg_replace;

/**
 * User Agent Normalizer - removes serial numbers from user agent
 */
final class SerialNumbers implements NormalizerInterface
{
    /**
     * @param string $userAgent
     *
     * @throws Exception
     *
     * @return string
     */
    public function normalize(string $userAgent): string
    {
        $normalized = preg_replace(['/\/SN[\dX]+/', '/\[(ST|TF|NT)[\dX]+\]/'], '', $userAgent);

        if (null === $normalized) {
            throw Exception::throw($userAgent);
        }

        return $normalized;
    }
}
