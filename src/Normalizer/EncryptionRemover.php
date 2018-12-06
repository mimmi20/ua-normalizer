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
 * User Agent Normalizer - removes encryption information from user agent
 */
final class EncryptionRemover implements NormalizerInterface
{
    /**
     * @param string $userAgent
     *
     * @throws \UnexpectedValueException
     *
     * @return string
     */
    public function normalize(string $userAgent): string
    {
        $userAgent  = str_replace('; UEAINT', '', $userAgent);
        $normalized = preg_replace('/; ?(I|U);/', ';', $userAgent);

        if (null === $normalized) {
            throw new \UnexpectedValueException(sprintf('an error occurecd while normalizing useragent "%s"', $userAgent));
        }

        return $normalized;
    }
}
