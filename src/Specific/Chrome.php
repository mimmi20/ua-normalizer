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
namespace UaNormalizer\Specific;

use UaNormalizer\NormalizerInterface;

/**
 * User Agent Normalizer - Return the Chrome string with the major version
 */
class Chrome implements NormalizerInterface
{
    /**
     * @param string $userAgent
     *
     * @return string
     */
    public function normalize($userAgent)
    {
        $pos = mb_strpos($userAgent, 'Chrome');

        if (false === $pos || 0 === $pos) {
            return $userAgent;
        }

        return mb_substr($userAgent, $pos);
    }
}
