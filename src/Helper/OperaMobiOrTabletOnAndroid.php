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

/**
 * OperaMobiOrTabletOnAndroidUserAgentHandler
 *
 *
 * @category   WURFL
 *
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 */
class OperaMobiOrTabletOnAndroid
{
    const OPERA_DEFAULT_VERSION = '10';

    private static $validOperaVersions = array('10', '11', '12');

    /**
     * Get the Opera browser version from an Opera Android user agent
     *
     * @param string $userAgent  User Agent
     * @param bool   $useDefault Return the default version on fail, else return null
     *
     * @return string Opera version
     *
     * @see self::$defaultOperaVersion
     */
    public static function getOperaOnAndroidVersion($userAgent, $useDefault = true)
    {
        if (preg_match('/Version\/(\d\d)/', $userAgent, $matches)) {
            $version = $matches[1];

            if (in_array($version, self::$validOperaVersions)) {
                return $version;
            }
        }

        return $useDefault ? self::OPERA_DEFAULT_VERSION : null;
    }
}
