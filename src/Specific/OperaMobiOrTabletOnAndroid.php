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
use UaNormalizer\Helper\OperaMobiOrTabletOnAndroid as OperaMobiOrTabletOnAndroidHelper;
use UaNormalizer\NormalizerInterface;

/**
 * User Agent Normalizer
 */
class OperaMobiOrTabletOnAndroid implements NormalizerInterface
{
    /**
     * @param string $userAgent
     *
     * @return string
     */
    public function normalize($userAgent)
    {
        $s = \Stringy\create($userAgent);

        $isOperaMobile = $s->contains('Opera Mobi');
        $isOperaTablet = $s->contains('Opera Tablet');

        if ($isOperaMobile || $isOperaTablet) {
            $operaVersion   = OperaMobiOrTabletOnAndroidHelper::getOperaOnAndroidVersion($userAgent, false);
            $androidVersion = AndroidHelper::getAndroidVersion($userAgent, false);

            if ($operaVersion !== null && $androidVersion !== null) {
                $operaModel = $isOperaTablet ? 'Opera Tablet' : 'Opera Mobi';
                $prefix     = $operaModel . ' ' . $operaVersion . ' Android ' . $androidVersion . '---';

                return $prefix . $userAgent;
            }
        }

        return $userAgent;
    }
}
