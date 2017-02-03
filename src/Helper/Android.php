<?php
/**
 * Copyright (c) 2015 ScientiaMobile, Inc.
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 * Refer to the LICENSE file distributed with this package.
 *
 * @category   WURFL
 *
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 */

namespace UaNormalizer\Helper;

/**
 * AndroidUserAgentHandler
 *
 * @category   WURFL
 *
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 */
class Android
{
    /********* Android Utility Functions ***********/

    /**
     * @var float
     */
    const ANDROID_DEFAULT_VERSION = 2.0;

    /**
     * @var array
     */
    public static $validAndroidVersions = [
        '1.0',
        '1.5',
        '1.6',
        '2.0',
        '2.1',
        '2.2',
        '2.3',
        '2.4',
        '3.0',
        '3.1',
        '3.2',
        '3.3',
        '4.0',
        '4.1',
        '4.2',
        '4.3',
        '4.4',
        '4.5',
        '5.0',
        '5.1',
        '5.2',
        '5.3',
        '6.0',
        '6.1',
    ];

    /**
     * @var array
     */
    private static $androidReleaseMap = [
        'Cupcake'            => '1.5',
        'Donut'              => '1.6',
        'Eclair'             => '2.1',
        'Froyo'              => '2.2',
        'Gingerbread'        => '2.3',
        'Honeycomb'          => '3.0',
        'Ice Cream Sandwich' => '4.0',
        'Jelly Bean'         => '4.1', // Note: 4.2/4.3 is also Jelly Bean
        'KitKat'             => '4.4',
    ];

    /**
     * Get the Android version from the User Agent, or the default Android version is it cannot be determined
     *
     * @param string $userAgent  User Agent
     * @param bool   $useDefault Return the default version on fail, else return null
     *
     * @return string Android version
     * @see self::ANDROID_DEFAULT_VERSION
     */
    public static function getAndroidVersion($userAgent, $useDefault = true)
    {
        // Replace Android version names with their numbers
        // ex: Froyo => 2.2
        $userAgent = str_replace(
            array_keys(self::$androidReleaseMap),
            array_values(self::$androidReleaseMap),
            $userAgent
        );

        // Initializing $version
        $version = null;

        // Look for 'Android <Version>' first and then for 'Android/<Version>'
        if (preg_match('#Android (\d\.\d)#', $userAgent, $matches)) {
            $version = $matches[1];
        } elseif (preg_match('#Android/(\d\.\d)#', $userAgent, $matches)) {
            $version = $matches[1];
        }

        // Now check extracted Android version for validity
        if (in_array($version, self::$validAndroidVersions)) {
            return $version;
        }

        return $useDefault ? self::ANDROID_DEFAULT_VERSION : null;
    }

    /**
     * Get the model name from the provided user agent or null if it cannot be determined
     *
     * @param string $userAgent
     *
     * @return null|string
     */
    public static function getAndroidModel($userAgent)
    {
        // Normalize spaces in UA before capturing parts
        $userAgent = preg_replace('|;(?! )|', '; ', $userAgent);

        // Logic to detect some Gionee UAs like: (must remain above the regular model name extracting regex)
        // Mozilla/5.0 (Linux; U; Android 4.2.2; zh-cn; Build/JDQ39 ) AppleWebKit/534.30 (KHTML,like Gecko) Version/4.2.2 Mobile Safari/534.30 GiONEE-GN9000/GN9000 RV/4.2.8 GNBR/5.0.0.v Id/0470FB91EE7E5465B21531B855F06353
        if (preg_match('#Mobile Safari/[\d\.]+ (GiONEE-[A-Za-z0-9]+)/#', $userAgent, $matches)) {
            $model = $matches[1];
            // Different logic for Mozillite and non-Mozillite UAs to isolate model name
            // Non-Mozillite UAs get first preference
        } elseif (preg_match(
            '#(^[A-Za-z0-9_\-\+ ]+)[/ ]?(?:[A-Za-z0-9_\-\+\.]+)? +Linux/[0-9\.\+]+ +Android[ /][0-9\.]+ +Release/[0-9\.]+#',
            $userAgent,
            $matches
        )) {
            // Trim off spaces and semicolons
            $model = rtrim($matches[1], ' ;');
            // Locales are optional for matching model name since UAs like Chrome Mobile do not contain them
        } elseif (preg_match('#Android [^;]+;(?>(?: xx-xx[ ;]+)?)(.+?)(?:Build/|\))#', $userAgent, $matches)) {
            // Trim off spaces and semicolons
            $model = rtrim($matches[1], ' ;');
            // Additional logic to capture model names in Amazon webview/appstore UAs
        } elseif (preg_match(
            '#^(?:AmazonWebView|Appstore|Amazon\.com)/.+Android[/ ][\d\.]+/(?:[\d]+/)?([A-Za-z0-9_\- ]+)\b#',
            $userAgent,
            $matches
        )) {
            $model = $matches[1];
        } else {
            return null;
        }

        // The previous RegEx may return just 'Build/.*' for UAs like:
        // HTC_Dream Mozilla/5.0 (Linux; U; Android 1.5; xx-xx; Build/CUPCAKE) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1
        if (strpos($model, 'Build/') === 0) {
            return null;
        }

        // Replace xx-xx (locale) in the model name with ''
        $model = str_replace('xx-xx', '', $model);

        // Normalize Chinese UAs
        $model = preg_replace('#(?:_CMCC_TD|_CMCC|_TD)\b#', '', $model);

        // Normalize models with resolution
        if (strpos($model, '*') !== false) {
            if (($pos = strpos($model, '/')) !== false) {
                $model = substr($model, 0, $pos);
            }
        }

        // Normalize Huawei UAs
        $model = str_replace('HW-HUAWEI_', 'HUAWEI ', $model);

        // Normalize Coolpad UAs
        if (strpos($model, 'YL-Coolpad') !== false) {
            $model = preg_replace('#YL-Coolpad[ _]#', 'Coolpad ', $model);
        }

        // HTC
        if (strpos($model, 'HTC') !== false) {
            // Normalize 'HTC/'
            $model = preg_replace('#HTC[ _\-/]#', 'HTC~', $model);

            // Remove the version
            if (($pos = strpos($model, '/')) !== false) {
                $model = substr($model, 0, $pos);
            }
            $model = preg_replace('#( V| )\d+?\.[\d\.]+$#', '', $model);
        }

        // Samsung
        $model = preg_replace('#(SAMSUNG[^/]+)/.*$#', '$1', $model);

        // Orange
        $model = preg_replace('#ORANGE/.*$#', 'ORANGE', $model);

        // LG
        $model = preg_replace('#(LG-?[A-Za-z0-9\-]+).*$#', '$1', $model);

        // Serial Number
        $model = preg_replace('#\[[\d]{10}\]#', '', $model);

        // Remove whitespace
        $model = trim($model);

        // Normalize Samsung and Sony/SonyEricsson model name changes due to Chrome Mobile
        $model = preg_replace('#^(?:SAMSUNG|SonyEricsson|Sony)[ \-]?#', '', $model);

        return (strlen($model) === 0) ? null : $model;
    }
}
