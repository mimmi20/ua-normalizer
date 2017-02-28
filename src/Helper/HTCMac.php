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
 * HTCMacUserAgentHandler
 */
class HTCMac
{
    /**
     * @param string $userAgent
     *
     * @return string|null
     */
    public static function getHTCMacModel($userAgent)
    {
        if (preg_match('/(HTC[^;\)]+)/', $userAgent, $matches)) {
            $model = preg_replace('#[ _\-/]#', '~', $matches[1]);

            return $model;
        }
    }
}
