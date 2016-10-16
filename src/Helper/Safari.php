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

namespace UaNormalizer\Helper;

use Wurfl\WurflConstants;

/**
 * SafariHandler
 *
 *
 * @category   WURFL
 *
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 */
class Safari
{
    /**
     * @param $userAgent
     *
     * @return null|string
     */
    public static function getSafariVersion($userAgent)
    {
        $search = 'Version/';
        $idx    = strpos($userAgent, $search);

        if ($idx === false) {
            return WurflConstants::NO_MATCH;
        }

        $idx += strlen($search);
        $endIdx = strpos($userAgent, '.', $idx);

        if ($endIdx === false) {
            return WurflConstants::NO_MATCH;
        }

        return substr($userAgent, $idx, $endIdx - $idx);
    }
}
