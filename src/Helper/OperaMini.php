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
 * OperaHandlder
 *
 *
 * @category   WURFL
 *
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 */
class OperaMini
{
    /**
     * Get the model name from the provided user agent or null if it cannot be determined
     *
     * @param string $ua
     *
     * @return null|string
     */
    public static function getOperaModel($ua)
    {
        if (preg_match('#^Opera/[\d\.]+ .+?\d{3}X\d{3} (.+)$#', $ua, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
