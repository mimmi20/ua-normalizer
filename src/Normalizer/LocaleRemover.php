<?php
/**
 * This file is part of the ua-normalizer package.
 *
 * Copyright (c) 2015-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace UaNormalizer\Normalizer;

/**
 * User Agent Normalizer - removes locale information from user agent
 */
class LocaleRemover implements NormalizerInterface
{
    /**
     * @param string $userAgent
     *
     * @return string
     */
    public function normalize(string $userAgent): string
    {
        if (preg_match('/(ca|fr)\-crawler/', $userAgent)) {
            return $userAgent;
        }

        $regex = '/(; ?)(a[defgilmoqrstuwxz]|b[abdefghijlmnoqrstvwyz]|c[acdfghiklmnoruvwxyz]|d[ejkmoz]|e[ceghnrst]|f[ijkmor]|g[abdefghilmnpqrstuwy]|h[kmnrtu]|i[delmnoqrst]|j[emop]|k[eghimnprwyz]|l[abcikrstuvy]|m[acdefghklmnopqrstuvwxyz]|n[acefgilopruz]|om|p[aefghklmnrstwy]|qa|r[eosuw]|s[abcdeghijklmnorstvxyz]|t[cdfghjklmnortvwz]|u[agmsyz]|v[aceginu]|w[fs]|y[et]|z[ahmw])([-_]r?[a-zA-Z]{2})?(\.utf8|\.big5)?(\b-?)(?!:)([;)])/';

        if (!preg_match($regex, $userAgent, $matches)) {
            return $userAgent;
        }

        $replacement = str_replace(
            ['; )', '; -;', '; ;', ';;'],
            [')', ';', ';', ';'],
            sprintf('%s%s%s%s', $matches[1], $matches[4], $matches[5], $matches[6])
        );

        return preg_replace($regex, $replacement, $userAgent);
    }
}
