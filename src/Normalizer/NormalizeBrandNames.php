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

use function str_ireplace;

/**
 * User Agent Normalizer - normalize brand names
 */
final class NormalizeBrandNames implements NormalizerInterface
{
    /** @throws void */
    #[Override]
    public function normalize(string $userAgent): string
    {
        $userAgent = str_ireplace(
            ['TECNO TECNO', 'TECNO MOBILE LIMITED TECNO', 'TECNO Mobile'],
            'TECNO',
            $userAgent,
        );

        return str_ireplace(
            ['MZ-MEIZU'],
            'MEIZU',
            $userAgent,
        );
    }
}
