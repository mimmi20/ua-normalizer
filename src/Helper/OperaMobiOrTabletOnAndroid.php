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
namespace UaNormalizer\Helper;

/**
 * OperaMobiOrTabletOnAndroidUserAgentHandler
 */
class OperaMobiOrTabletOnAndroid
{
    const OPERA_DEFAULT_VERSION = '10';

    private static $validOperaVersions = ['10', '11', '12'];

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
