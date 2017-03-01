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
 * WebOSUserAgentHandler
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
    }
}
