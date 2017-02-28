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
 * User Agent Normalizer - removes YesWAP garbage from user agent
 */
class YesWAP implements NormalizerInterface
{
    /**
     * @var string
     */
    const YES_WAP_REGEX = '/\\s*Mozilla\\/4\\.0 \\(YesWAP mobile phone proxy\\)/';

    /**
     * @param string $userAgent
     *
     * @return string
     */
    public function normalize($userAgent)
    {
        return preg_replace(self::YES_WAP_REGEX, '', $userAgent);
    }
}
