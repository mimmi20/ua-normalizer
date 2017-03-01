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
 * MaemoUserAgentHandler
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
            $idx   = mb_strpos($model, ' GTB');

            if ($idx !== false) {
                $model = mb_substr($model, 0, $idx);
            }

            return $model;
        }
    }
}
