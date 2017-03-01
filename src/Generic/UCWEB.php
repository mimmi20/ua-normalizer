<?php
/**
 * This file is part of the ua-normalizer package.
 *
 * Copyright (c) 2015-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace UaNormalizer\Generic;

use UaNormalizer\NormalizerInterface;

/**
 * User Agent Normalizer - removes UCWEB garbage from user agent
 */
class UCWEB implements NormalizerInterface
{
    /**
     * This method remove the 'UP.Link' substring from user agent string.
     *
     * @param string $userAgent
     *
     * @return string Normalized user agent
     */
    public function normalize($userAgent)
    {
        // Starts with 'JUC' or 'Mozilla/5.0(Linux;U;Android'
        if (mb_strpos($userAgent, 'JUC') === 0 || mb_strpos($userAgent, 'Mozilla/5.0(Linux;U;Android') === 0) {
            $userAgent = preg_replace('/^(JUC \(Linux; U;)(?= \d)/', '$1 Android', $userAgent);
            $userAgent = preg_replace('/(Android|JUC|[;\)])(?=[\w|\(])/', '$1 ', $userAgent);
        }

        return $userAgent;
    }
}
