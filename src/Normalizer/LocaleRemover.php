<?php

/**
 * This file is part of the ua-normalizer package.
 *
 * Copyright (c) 2015-2024, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace UaNormalizer\Normalizer;

use Override;

use function preg_match;
use function preg_replace;
use function sprintf;
use function str_replace;

/**
 * User Agent Normalizer - removes locale information from user agent
 */
final class LocaleRemover implements NormalizerInterface
{
    private const string REGEX = '/(?P<prefix>; ?)(?P<lang>a[defgilmoqrstuwxz]|b[abdefghijlmnoqrstvwyz]|c[acdfghiklmnoruvwxyz]|d[ejkmoz]|e[ceghnrst]|f[ijkmor]|g[abdefghilmnpqrstuwy]|h[kmnrtu]|i[delmnoqrst]|j[emop]|k[eghimnprwyz]|l[abcikrstuvy]|m[acdefghklmnopqrstuvwxyz]|n[acefgilopruz]|om|p[aefghklmnrstwy]|qa|r[eosuw]|s[abcdeghijklmnorstvxyz]|t[cdfghjklmnortvwz]|u[agmsyz]|v[aceginu]|w[fs]|y[et]|z[ahmw])(?P<state>[-_]r?[a-zA-Z]{2})?(?P<utf>\.utf8|\.big5)?(?P<b>\b-?)(?!:)(?P<end>[;)])/';

    /** @throws void */
    #[Override]
    public function normalize(string $userAgent): string | null
    {
        if (preg_match('/(ca|fr)-crawler/', $userAgent)) {
            return $userAgent;
        }

        if (!preg_match(self::REGEX, $userAgent, $matches)) {
            return $userAgent;
        }

        $replacement = str_replace(
            ['; )', '; -;', '; ;', ';;'],
            [')', ';', ';', ';'],
            sprintf('%s%s%s%s', $matches['prefix'], $matches['utf'], $matches['b'], $matches['end']),
        );

        return preg_replace(self::REGEX, $replacement, $userAgent);
    }
}
