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
 * OperaHandlder
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
    }
}
