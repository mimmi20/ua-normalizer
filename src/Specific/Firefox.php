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
 * User Agent Normalizer - Return the firefox string with the major and minor version only
 */
class Firefox implements NormalizerInterface
{
    /**
     * @param string $userAgent
     *
     * @return string
     */
    public function normalize($userAgent)
    {
        return $this->firefoxWithMajorAndMinorVersion($userAgent);
    }

    /**
     * Returns FireFox major and minor version numbers
     *
     * @param string $userAgent
     *
     * @return string Major and minor version
     */
    private function firefoxWithMajorAndMinorVersion($userAgent)
    {
        return mb_substr($userAgent, mb_strpos($userAgent, 'Firefox'));
    }
}
