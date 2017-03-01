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
