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

use UaNormalizer\Helper\UcwebU3 as UcwebU3Helper;
use UaNormalizer\NormalizerInterface;

/**
 * User Agent Normalizer
 */
class UcwebU2 implements NormalizerInterface
{
    /**
     * @param string $userAgent
     *
     * @return string
     */
    public function normalize($userAgent)
    {
        $ucbVersion = UcwebU3Helper::getUcBrowserVersion($userAgent);

        if ($ucbVersion === null) {
            return $userAgent;
        }

        $s = \Stringy\create($userAgent);

        //Android U2K Mobile + Tablet
        if ($s->contains('Adr ')) {
            $model   = UcwebU3Helper::getUcAndroidModel($userAgent, false);
            $version = UcwebU3Helper::getUcAndroidVersion($userAgent, false);

            if ($model !== null && $version !== null) {
                $prefix = $version . ' U2Android ' . $ucbVersion . ' ' . $model . '---';

                return $prefix . $userAgent;
            }
        } elseif ($s->contains('iPh OS')) {
            //iPhone U2K
            if (preg_match('/iPh OS (\d)_?(\d)?[ _\d]?.+; iPh(\d), ?(\d)\) U2/', $userAgent, $matches)) {
                $version = $matches[1] . '.' . $matches[2];
                $model   = $matches[3] . '.' . $matches[4];
                $prefix  = $version . ' U2iPhone ' . $ucbVersion . ' ' . $model . '---';

                return $prefix . $userAgent;
            }
        } elseif ($s->contains('wds')) {
            //WP7&8 U2K
            //Add spaces and normalize
            $userAgent = preg_replace('|;(?! )|', '; ', $userAgent);
            if (preg_match(
                '/^UCWEB.+; wds (\d+)\.([\d]+);.+; ([ A-Za-z0-9_-]+); ([ A-Za-z0-9_-]+)\) U2/',
                $userAgent,
                $matches
            )) {
                $version = $matches[1] . '.' . $matches[2];
                $model   = $matches[3] . '.' . $matches[4];
                //Standard normalization stuff from WP matcher
                $model  = str_replace('_blocked', '', $model);
                $model  = preg_replace('/(NOKIA.RM-.+?)_.*/', '$1', $model, 1);
                $prefix = $version . ' U2WindowsPhone ' . $ucbVersion . ' ' . $model . '---';

                return $prefix . $userAgent;
            }
        } elseif ($s->contains('Symbian')) {
            //Symbian U2K
            if (preg_match('/^UCWEB.+; S60 V(\d); .+; (.+)\) U2/', $userAgent, $matches)) {
                $version = 'S60 V' . $matches[1];
                $model   = $matches[2];
                $prefix  = $version . ' U2Symbian ' . $ucbVersion . ' ' . $model . '---';

                return $prefix . $userAgent;
            }
        } elseif ($s->contains('Java')) {
            //Java U2K - check results for regex
            if (preg_match('/^UCWEB[^\(]+\(Java; .+; (.+)\) U2/', $userAgent, $matches)) {
                $version = 'Java';
                $model   = $matches[1];
                $prefix  = $version . ' U2JavaApp ' . $ucbVersion . ' ' . $model . '---';

                return $prefix . $userAgent;
            }
        }

        return $userAgent;
    }
}
