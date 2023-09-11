<?php
/**
 * This file is part of the ua-normalizer package.
 *
 * Copyright (c) 2015-2023, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace UaNormalizer\Normalizer;

use function count;

/**
 * User Agent Normalizer
 */
final class NormalizerChain implements NormalizerInterface
{
    /**
     * Set the User Agent Normalizers
     *
     * @param array<NormalizerInterface> $normalizers
     *
     * @throws void
     */
    public function __construct(
        /**
         * UserAgentNormalizer chain - array of \UaNormalizer\UserAgentNormalizer objects
         *
         * @throws void
         */
        private array $normalizers = [],
    ) {
        // nothing to do
    }

    /**
     * Adds a new UserAgent Normalizer to the chain
     *
     * @throws void
     */
    public function add(NormalizerInterface $normalizer): void
    {
        $this->normalizers[] = $normalizer;
    }

    /**
     * Return the number of normalizers currently registered
     *
     * @return int count
     *
     * @throws void
     */
    public function count(): int
    {
        return count($this->normalizers);
    }

    /**
     * Normalize the given $userAgent by passing down the chain
     * of normalizers
     *
     * @return string Normalized user agent
     *
     * @throws Exception
     */
    public function normalize(string $userAgent): string
    {
        $normalizedUserAgent = $userAgent;

        foreach ($this->normalizers as $normalizer) {
            $normalizedUserAgent = $normalizer->normalize($normalizedUserAgent);

            if ($normalizedUserAgent === null) {
                throw Exception::throw($userAgent);
            }
        }

        return $normalizedUserAgent;
    }
}
