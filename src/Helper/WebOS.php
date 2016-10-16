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
 * WebOSUserAgentHandler
 *
 *
 * @category   WURFL
 *
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 */
class WebOS
{
    /**
     * @param $userAgent
     *
     * @return null|string
     */
    public static function getWebOSModelVersion($userAgent)
    {
        /* Formats:
         * Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.5; U; es-US) ... wOSBrowser/234.83 Safari/534.6 TouchPad/1.0
         * Mozilla/5.0 (Linux; webOS/2.2.4; U; de-DE) ... webOSBrowser/221.56 Safari/534.6 Pre/3.0
         * Mozilla/5.0 (webOS/1.4.0; U; en-US) ... Version/1.0 Safari/532.2 Pre/1.0
         */
        if (preg_match('# ([^/]+)/([\d\.]+)$#', $userAgent, $matches)) {
            return $matches[1] . ' ' . $matches[2];
        }

        return WurflConstants::NO_MATCH;
    }

    /**
     * @param $userAgent
     *
     * @return null|string
     */
    public static function getWebOSVersion($userAgent)
    {
        if (preg_match('#(?:hpw|web)OS.(\d)\.#', $userAgent, $matches)) {
            return 'webOS' . $matches[1];
        }

        return WurflConstants::NO_MATCH;
    }
}
