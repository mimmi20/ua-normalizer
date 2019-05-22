<?php
/**
 * This file is part of the ua-normalizer package.
 *
 * Copyright (c) 2015-2019, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace UaNormalizer\Normalizer;

use Safe\Exceptions\PcreException;
use Safe\Exceptions\StringsException;
use function Safe\preg_match;
use function Safe\preg_replace;
use function Safe\sprintf;
use function str_replace;

/**
 * User Agent Normalizer - removes locale information from user agent
 */
final class LocaleRemover implements NormalizerInterface
{
    /**
     * @param string $userAgent
     *
     * @throws Exception
     *
     * @return string
     */
    public function normalize(string $userAgent): string
    {
        try {
            $match = preg_match('/(?:ca|fr)\-crawler/', $userAgent);
        } catch (PcreException $e) {
            throw Exception::throw($userAgent, $e);
        }

        if ((bool) $match) {
            return $userAgent;
        }

        $regex = '/(; ?)(a[defgilmoqrstuwxz]|b[abdefghijlmnoqrstvwyz]|c[acdfghiklmnoruvwxyz]|d[ejkmoz]|e[ceghnrst]|f[ijkmor]|g[abdefghilmnpqrstuwy]|h[kmnrtu]|i[delmnoqrst]|j[emop]|k[eghimnprwyz]|l[abcikrstuvy]|m[acdefghklmnopqrstuvwxyz]|n[acefgilopruz]|om|p[aefghklmnrstwy]|qa|r[eosuw]|s[abcdeghijklmnorstvxyz]|t[cdfghjklmnortvwz]|u[agmsyz]|v[aceginu]|w[fs]|y[et]|z[ahmw])([-_]r?[a-zA-Z]{2})?(\.utf8|\.big5)?(\b-?)(?!:)([;)])/';

        try {
            $match = preg_match($regex, $userAgent, $matches);
        } catch (PcreException $e) {
            throw Exception::throw($userAgent, $e);
        }

        if (!(bool) $match) {
            return $userAgent;
        }

        try {
            $search = sprintf('%s%s%s%s', $matches[1], $matches[4], $matches[5], $matches[6]);
        } catch (StringsException $e) {
            throw Exception::throw($userAgent, $e);
        }

        $replacement = str_replace(
            ['; )', '; -;', '; ;', ';;'],
            [')', ';', ';', ';'],
            $search
        );

        try {
            $normalized = preg_replace($regex, $replacement, $userAgent);
        } catch (PcreException $e) {
            throw Exception::throw($userAgent, $e);
        }

        return $normalized;
    }
}
