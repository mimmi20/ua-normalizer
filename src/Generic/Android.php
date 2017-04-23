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
 * User Agent Normalizer
 */
class Android implements NormalizerInterface
{
    /**
     * @param string $userAgent
     *
     * @return string
     */
    public function normalize($userAgent)
    {
        $userAgent = str_ireplace('2.1-update1', '2.1.1', $userAgent);

        // Normalize Android version
        return preg_replace('/(Android)[ \-\/]([\d\.]+)([^; \/\)\d\.]+)/', '$1 $2', $userAgent);
    }
}
