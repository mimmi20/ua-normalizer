<?php
/**
 * This file is part of the ua-normalizer package.
 *
 * Copyright (c) 2015-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace UaNormalizer\Normalizer;

/**
 * User Agent Normalizer - normalizes the KHTML, like Gecko Token from user agent
 */
class KhtmlGecko implements NormalizerInterface
{
    /**
     * @param string $userAgent
     *
     * @return string Normalized user agent
     */
    public function normalize(string $userAgent): string
    {
        return trim(preg_replace('/ *\(K?(HT|TH)ML,? *like ?Gecko\) */', ' (KHTML, like Gecko) ', $userAgent));
    }
}