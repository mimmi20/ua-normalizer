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
 * User Agent Normalizer - Returns the Thunderbird/{Version} sub-string
 */
class DesktopApplication implements NormalizerInterface
{
    /**
     * @param string $userAgent
     *
     * @return string
     */
    public function normalize($userAgent)
    {
        $idx = mb_strpos($userAgent, 'Thunderbird');

        if ($idx !== false) {
            return mb_substr($userAgent, $idx);
        }

        return $userAgent;
    }
}
