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
use function str_ireplace;

/**
 * User Agent Normalizer - normalize brand names
 */
final class NormalizeBrandNames implements NormalizerInterface
{
    /** @throws void */
    #[Override]
    public function normalize(string $userAgent): string | null
    {
        $userAgent = str_ireplace(
            ['TECNO TECNO', 'TECNO MOBILE LIMITED TECNO', 'TECNO Mobile'],
            'TECNO',
            $userAgent,
        );

        $userAgent = str_ireplace(
            ['MZ-MEIZU'],
            'MEIZU',
            $userAgent,
        );

        if (
            preg_match('/(moto(?:rola)? [eg][^-]+)[^)\/]*\)/i', $userAgent)
            && preg_match('/(moto(?:rola)? [eg].+ -)[^)\/]*\)/i', $userAgent)
        ) {
            return $userAgent;
        }

        return preg_replace('/(moto(?:rola)? [eg][^-]+)[^)\/]*\)/i', '$1)', $userAgent);
    }
}
