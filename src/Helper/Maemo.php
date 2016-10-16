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

use Wurfl\WurflConstants;

/**
 * MaemoUserAgentHandler
 *
 *
 * @category   WURFL
 *
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 */
class Maemo
{
    /**
     * @param $userAgent
     *
     * @return null|string
     */
    public static function getMaemoModel($userAgent)
    {
        if (preg_match('/Maemo [bB]rowser [\d\.]+ (.+)/', $userAgent, $matches)) {
            $model = $matches[1];
            $idx   = strpos($model, ' GTB');

            if ($idx !== false) {
                $model = substr($model, 0, $idx);
            }

            return $model;
        }

        return WurflConstants::NO_MATCH;
    }
}
