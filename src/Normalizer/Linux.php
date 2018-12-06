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
 * User Agent Normalizer - normalizes/fixes "Linux" token in user agent
 */
final class Linux implements NormalizerInterface
{
    /**
     * @param string $userAgent
     *
     * @throws \UnexpectedValueException
     *
     * @return string Normalized user agent
     */
    public function normalize(string $userAgent): string
    {
        $normalized = preg_replace('/\(Linu(s|x); */', '(Linux; ', $userAgent);

        if (null === $normalized) {
            throw new \UnexpectedValueException(sprintf('an error occurecd while normalizing useragent "%s"', $userAgent));
        }

        return $normalized;
    }
}
