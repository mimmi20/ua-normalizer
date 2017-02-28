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
