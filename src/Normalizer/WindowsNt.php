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
use function Safe\preg_replace;

/**
 * User Agent Normalizer - normalizes/fixes the "Windows NT" token in user agent
 */
final class WindowsNt implements NormalizerInterface
{
    /**
     * @param string $userAgent
     *
     * @throws Exception
     *
     * @return string Normalized user agent
     */
    public function normalize(string $userAgent): string
    {
        try {
            $normalized = preg_replace('/windows[ \-]?nt/i', 'Windows NT', $userAgent);
        } catch (PcreException $e) {
            throw Exception::throw($userAgent, $e);
        }

        return $normalized;
    }
}
