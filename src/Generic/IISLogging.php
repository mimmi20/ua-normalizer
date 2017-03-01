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
 * User Agent Normalizer - clean IIS Logging from user agent
 */
class IISLogging implements NormalizerInterface
{
    /**
     * This method clean the IIS logging from user agent string.
     *
     * @param string $userAgent
     *
     * @return string Normalized user agent
     */
    public function normalize($userAgent)
    {
        //If there are no spaces in a UA and more than 2 plus symbols, the UA is likely affected by IIS style logging issues
        if (mb_substr_count($userAgent, ' ') === 0 and mb_substr_count($userAgent, '+') > 2) {
            $userAgent = str_replace('+', ' ', $userAgent);
        }

        return $userAgent;
    }
}
