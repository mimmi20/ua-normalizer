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
 * User Agent Normalizer - returns the substring starting from 'BlackBerry'
 */
class BlackBerry implements NormalizerInterface
{
    /**
     * @param string $userAgent
     *
     * @return mixed|string
     */
    public function normalize($userAgent)
    {
        $userAgent = str_ireplace('blackberry', 'BlackBerry', $userAgent);

        $pos = mb_strpos($userAgent, 'BlackBerry');

        if (false === $pos || 0 === $pos) {
            return $userAgent;
        }

        return mb_substr($userAgent, $pos);
    }
}
