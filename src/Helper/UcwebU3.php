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

use UaNormalizer\Helper\Android as AndroidHelper;
use Wurfl\WurflConstants;

/**
 * UcwebU3UserAgentHandler
 *
 *
 * @category   WURFL
 *
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 */
class UcwebU3
{
    /**
     * @param string $userAgent
     *
     * @return string|null
     */
    public static function getUcBrowserVersion($userAgent)
    {
        if (preg_match('/UCBrowser\/(\d+)\.\d/', $userAgent, $matches)) {
            $ucVersion = $matches[1];

            return $ucVersion;
        }

        return WurflConstants::NO_MATCH;
    }

    /**
     * @param string $userAgent
     * @param bool   $useDefault
     *
     * @return float|null
     */
    public static function getUcAndroidVersion($userAgent, $useDefault = true)
    {
        if (preg_match('/; Adr (\d+\.\d+)\.?/', $userAgent, $matches)) {
            $u2k_an_version = $matches[1];

            if (in_array($u2k_an_version, AndroidHelper::$validAndroidVersions)) {
                return $u2k_an_version;
            }
        }

        return $useDefault ? AndroidHelper::ANDROID_DEFAULT_VERSION : WurflConstants::NO_MATCH;
    }

    /**
     * Slightly modified from Android's get model function
     *
     * @param $userAgent
     *
     * @return null|string
     */
    public static function getUcAndroidModel($userAgent)
    {
        // Locales are optional for matching model name since UAs like Chrome Mobile do not contain them
        if (!preg_match('#Adr [\d\.]+; [a-zA-Z]+-[a-zA-Z]+; (.*)\) U2#', $userAgent, $matches)) {
            return WurflConstants::NO_MATCH;
        }

        $model = $matches[1];

        // HTC
        if (strpos($model, 'HTC') !== false) {
            // Normalize "HTC/"
            $model = preg_replace('#HTC[ _\-/]#', 'HTC~', $model);
            // Remove the version
            $model = preg_replace('#(/| +V?\d)[\.\d]+$#', '', $model);
            $model = preg_replace('#/.*$#', '', $model);
        }

        // Samsung
        $model = preg_replace('#(SAMSUNG[^/]+)/.*$#', '$1', $model);
        // Orange
        $model = preg_replace('#ORANGE/.*$#', 'ORANGE', $model);
        // LG
        $model = preg_replace('#(LG-[A-Za-z0-9\-]+).*$#', '$1', $model);
        // Serial Number
        $model = preg_replace('#\[[\d]{10}\]#', '', $model);

        $model = trim($model);

        return (strlen($model) === 0) ? WurflConstants::NO_MATCH : $model;
    }
}
