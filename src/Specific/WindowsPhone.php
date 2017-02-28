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

        if ($s->containsAny(['WPDesktop', 'ZuneWP7'])
            || $s->containsAll(['Mozilla/5.0 (Windows NT ', ' ARM;', ' Edge/'])
        ) {
            $model   = WindowsPhoneHelper::getWindowsPhoneDesktopModel($userAgent);
            $version = WindowsPhoneHelper::getWindowsPhoneDesktopVersion($userAgent);
        } elseif (Utils::checkIfStartsWithAnyOf($userAgent, ['Windows Phone Ad Client', 'WindowsPhoneAdClient'])) {
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
