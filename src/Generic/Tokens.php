<?php
/**
 * Copyright (c) 2015 ScientiaMobile, Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * Refer to the LICENSE file distributed with this package.
 *
 *
 * @category   WURFL
 *
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 */

namespace UaNormalizer\Generic;

use UaNormalizer\NormalizerInterface;

/**
 * User Agent Normalizer - replaces damaged tokens in the user agent
 */
class Tokens implements NormalizerInterface
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
        $userAgent = preg_replace('/([\d]+)EMobile/', '$1; IEMobile', $userAgent);
        $userAgent = str_replace('Macintoshntel', 'Macintosh; Intel', $userAgent);
        $userAgent = str_replace('cpu=PPC=Mac', 'cpu=PPC;os=Mac', $userAgent);
        $userAgent = preg_replace('/([\\\\]+)/i', '', $userAgent);
        $userAgent = preg_replace('/Versio\//', 'Version/', $userAgent);
        $userAgent = str_replace('i686 (x86_64)', 'i686 on x86_64', $userAgent);
        $userAgent = str_replace('X11buntu', 'X11; Ubuntu', $userAgent);
        return $userAgent;
    }
}
