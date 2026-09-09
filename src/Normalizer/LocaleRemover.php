<?php

/**
 * This file is part of the ua-normalizer package.
 *
 * Copyright (c) 2015-2026, Thomas Mueller <mimmi20@live.de>
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
    private const string REGEX = '/(?P<prefix>; ?)(?P<lang>a[defgilmoqrstuwxz]|b[abdefghijlmnoqrstvwyz]|chr|c[acdfghiklmnorsuvwxyz]|deu|d[aejkmoz]|eng|e[ceghlnrstu]|f[aijkmor]|g[abdefghilmnpqrstuwy]|haw|h[deikmnrtuy]|i[delmnoqrstw]|j[aemop]|k[aeghikmnoprwyz]|l[abcgikrstuvy]|m[acdefghklmnopqrstuvwxyz]|n[a-cefgilopruz]|om|p[aefghklmnrstwy]|qa|r[eosuw]|s[abcdeghijklmnoqrstvxyz]|t[acdfghjklmnortvwz]|u[agkmsyz]|v[aceginu]|w[fs]|xx|y[ety]|zh-han[st]|z[ahmwz]|[0-9]{2}(?!;))?(?P<state>[-_]r?-?[a-z0-9.]{1,3})?(?P<utf>\.utf8|\.big5)?(?:(?P<b>\b-?)(?!:))?(?P<end> ?[,;)])/i';

    /** @throws void */
    #[Override]
    public function normalize(string $userAgent): string | null
    {
        if (preg_match('/(ca|fr)-crawler/', $userAgent)) {
            return $userAgent;
        }

        $removals = [
            '/ +zh_CN_#Hans;/i',
            '/ +xx;/i',
            '/ +\-;/i',
            '/ %lang2%;/i',
        ];

        foreach ($removals as $removal) {
            $userAgent = (string) preg_replace($removal, '', $userAgent);
        }

        if ($userAgent === '' || !preg_match(self::REGEX, $userAgent, $matches)) {
            return $userAgent;
        }

        $replacement = str_replace(
            ['; )', '; -;', '; ;', ';;', '; ,', ';  ;'],
            [')', ';', ';', ';', ';', ';'],
            sprintf('%s%s%s%s', $matches['prefix'], $matches['utf'], $matches['b'], $matches['end']),
        );

        return preg_replace(self::REGEX, $replacement, $userAgent);
    }
}
