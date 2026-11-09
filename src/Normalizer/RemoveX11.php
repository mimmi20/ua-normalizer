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
use function str_ireplace;

/**
 * User Agent Normalizer - normalizes/fixes "X11" token in user agent
 */
final class RemoveX11 implements NormalizerInterface
{
    /** @throws void */
    #[Override]
    public function normalize(string $userAgent): string | null
    {
        $userAgent = preg_replace(
            ['/\s+/', '/\((?:x11;? ?|unknown; |wayland; )?((?:x86_64 )?linu[sx]|fedora|ubuntu|openbsd|freebsd|cros |debian|sunos|intel|gentoo|netbsd|win95|dragonfly)(?:; x11)?/i'],
            [' ', '($1'],
            $userAgent,
        );

        $userAgent = str_ireplace(['(x11)', '(x11;)'], '', (string) $userAgent);

        return preg_replace('/\s+/', ' ', $userAgent);
    }
}
