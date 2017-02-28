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

use UaNormalizer\Helper\WebOS as WebOSHelper;
use UaNormalizer\NormalizerInterface;

/**
 * User Agent Normalizer
 */
class WebOS implements NormalizerInterface
{
    /**
     * @param string $userAgent
     *
     * @return string
     */
    public function normalize($userAgent)
    {
        $model     = WebOSHelper::getWebOSModelVersion($userAgent);
        $osVersion = WebOSHelper::getWebOSVersion($userAgent);

        if ($model !== null && $osVersion !== null) {
            $prefix = $model . ' ' . $osVersion . '---';

            return $prefix . $userAgent;
        }

        return $userAgent;
    }
}
