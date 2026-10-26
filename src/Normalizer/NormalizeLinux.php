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

use function preg_replace;

/**
 * User Agent Normalizer - normalizes/fixes "Linux" token in user agent
 */
final class NormalizeLinux implements NormalizerInterface
{
    /** @throws void */
    #[Override]
    public function normalize(string $userAgent): string | null
    {
        $userAgent = preg_replace(
            '/\((?:x11; |unknown; |wayland; )?(?:x86_64 )?linu[sx](?:; x11)?/i',
            '(Linux',
            $userAgent,
        );

        $userAgent = preg_replace(
            '/\((?:x11; |unknown; |wayland; )?fedora(?:; x11)?/i',
            '(Fedora',
            (string) $userAgent,
        );

        $userAgent = preg_replace(
            '/\((?:x11; |unknown; |wayland; )?ubuntu(?:; x11)?/i',
            '(Ubuntu',
            (string) $userAgent,
        );

        return preg_replace(
            '/\((?:x11; |unknown; |wayland; )?openbsd(?:; x11)?/i',
            '(OpenBSD',
            (string) $userAgent,
        );
    }
}
