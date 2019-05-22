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
use function str_replace;

/**
 * User Agent Normalizer - removes encryption information from user agent
 */
final class EncryptionRemover implements NormalizerInterface
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
        $userAgent = str_replace('; UEAINT', '', $userAgent);

        try {
            $normalized = preg_replace('/; ?(I|U);/', ';', $userAgent);
        } catch (PcreException $e) {
            throw Exception::throw($userAgent, $e);
        }

        return $normalized;
    }
}
