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

namespace UaNormalizer\Specific;

use UaNormalizer\Helper\Utils;
use UaNormalizer\Helper\WindowsPhone as WindowsPhoneHelper;
use UaNormalizer\NormalizerInterface;

/**
 * User Agent Normalizer
 */
class WindowsPhone implements NormalizerInterface
{
    /**
     * @param string $userAgent
     *
     * @return string
     */
    public function normalize($userAgent)
    {
        $s = \Stringy\create($userAgent);

        if ($s->containsAny(array('WPDesktop', 'ZuneWP7'))
            || $s->containsAll(array('Mozilla/5.0 (Windows NT ', ' ARM;', ' Edge/'))
        ) {
            $model   = WindowsPhoneHelper::getWindowsPhoneDesktopModel($userAgent);
            $version = WindowsPhoneHelper::getWindowsPhoneDesktopVersion($userAgent);
        } elseif (Utils::checkIfStartsWithAnyOf($userAgent, array('Windows Phone Ad Client', 'WindowsPhoneAdClient'))) {
            $model   = WindowsPhoneHelper::getWindowsPhoneAdClientModel($userAgent);
            $version = WindowsPhoneHelper::getWindowsPhoneVersion($userAgent);
        } elseif ($s->contains('NativeHost')) {
            return $userAgent;
        } else {
            $model   = WindowsPhoneHelper::getWindowsPhoneModel($userAgent);
            $version = WindowsPhoneHelper::getWindowsPhoneVersion($userAgent);
        }

        if ($model !== null && $version !== null) {
            // 'WP' is for Windows Phone
            $prefix = 'WP' . $version . ' ' . $model . '---';

            return $prefix . $userAgent;
        }

        return $userAgent;
    }
}
