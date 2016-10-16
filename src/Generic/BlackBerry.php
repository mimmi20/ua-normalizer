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
        $pos       = strpos($userAgent, 'BlackBerry');

        if ($pos !== false && $pos > 0) {
            $userAgent = substr($userAgent, $pos);
        }

        return $userAgent;
    }
}
