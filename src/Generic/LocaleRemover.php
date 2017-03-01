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
 * User Agent Normalizer - removes locale information from user agent
 */
class LocaleRemover implements NormalizerInterface
{
    /**
     * @param string $userAgent
     *
     * @return string
     */
    public function normalize($userAgent)
    {
        return preg_replace('/; ?[a-z]{2}(?:[-_]r?[a-zA-Z]{2})?(?:\.utf8|\.big5)?\b-?(?!:)/', '', $userAgent);
    }
}
