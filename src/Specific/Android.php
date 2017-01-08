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

use UaNormalizer\Helper\Android as AndroidHelper;
use UaNormalizer\NormalizerInterface;

/**
 * User Agent Normalizer
 */
class Android implements NormalizerInterface
{
    /**
     * @param string $userAgent
     *
     * @return string
     */
    public function normalize($userAgent)
    {
        // Normalize Android version
        $model   = AndroidHelper::getAndroidModel($userAgent, false);
        $version = AndroidHelper::getAndroidVersion($userAgent, false);

        if ($model !== null && $version !== null) {
            $prefix = $version . ' ' . $model . '---';

            return $prefix . $userAgent;
        }

        return $userAgent;
    }
}
