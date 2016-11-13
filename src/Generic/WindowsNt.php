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
 * User Agent Normalizer - removes UCWEB garbage from user agent
 */
class WindowsNt implements NormalizerInterface
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
        return preg_replace('/windows[ \-]nt/i', 'Windows NT', $userAgent);
    }
}
