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

use UaNormalizer\Helper\OperaMini as OperaMiniHelper;
use UaNormalizer\NormalizerInterface;

/**
 * User Agent Normalizer
 */
class OperaMini implements NormalizerInterface
{
    public function normalize($userAgent)
    {
        $model = OperaMiniHelper::getOperaModel($userAgent, false);

        if ($model !== null) {
            $prefix    = $model . '---';
            $userAgent = $prefix . $userAgent;

            return $userAgent;
        }

        return $userAgent;
    }
}
