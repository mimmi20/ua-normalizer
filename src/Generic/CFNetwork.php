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
namespace UaNormalizer\Generic;

use UaNormalizer\NormalizerInterface;

/**
 * User Agent Normalizer - CFNetwork UA Resolution
 */
class CFNetwork implements NormalizerInterface
{
    /**
     * @param string $userAgent
     *
     * @return mixed|string
     */
    public function normalize($userAgent)
    {
        //Match a CFNetwork UA
        if (preg_match('#CFNetwork/(\d+\.?[0-9]*)#', $userAgent, $matches)) {
            $cfNetworkVersion = sprintf('%.2f', round($matches[1], 2, PHP_ROUND_HALF_DOWN));

            return 'CFNetwork/' . $cfNetworkVersion . ' ' . $userAgent;
        }

        return $userAgent;
    }
}
