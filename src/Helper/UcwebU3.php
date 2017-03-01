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

use UaNormalizer\Helper\Android as AndroidHelper;

/**
 * UcwebU3UserAgentHandler
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

        return $useDefault ? AndroidHelper::ANDROID_DEFAULT_VERSION : null;
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
            return;
        }

        $model = $matches[1];

        // HTC
        if (mb_strpos($model, 'HTC') !== false) {
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

        return (mb_strlen($model) === 0) ? null : $model;
    }
}
