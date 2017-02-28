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
 * SafariHandler
 */
class Safari
{
    /**
     * @param $userAgent
     *
     * @return null|string
     */
    public static function getSafariVersion($userAgent)
    {
        $search = 'Version/';
        $idx    = mb_strpos($userAgent, $search);

        if ($idx === false) {
            return;
        }

        $idx += mb_strlen($search);
        $endIdx = mb_strpos($userAgent, '.', $idx);

        if ($endIdx === false) {
            return;
        }

        return mb_substr($userAgent, $idx, $endIdx - $idx);
    }
}
