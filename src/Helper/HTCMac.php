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
 * HTCMacUserAgentHandler
 *
 *
 * @category   WURFL
 *
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
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

        return null;
    }
}
