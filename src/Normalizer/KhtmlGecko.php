<?php
/**
 * This file is part of the ua-normalizer package.
 *
 * Copyright (c) 2015-2020, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace UaNormalizer\Normalizer;

use function preg_replace;

/**
 * User Agent Normalizer - normalizes the KHTML, like Gecko Token from user agent
 */
final class KhtmlGecko implements NormalizerInterface
{
    /**
     * @param string $userAgent
     *
     * @throws Exception
     *
     * @return string Normalized user agent
     */
    public function normalize(string $userAgent): string
    {
        $normalized = preg_replace('/ *\(K?(HT|TH)ML,? *like ?Gecko\) */', ' (KHTML, like Gecko) ', $userAgent);

        if (null === $normalized) {
            throw Exception::throw($userAgent);
        }

        return $normalized;
    }
}
