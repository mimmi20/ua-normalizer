<?php
/**
 * This file is part of the ua-normalizer package.
 *
 * Copyright (c) 2015-2021, Thomas Mueller <mimmi20@live.de>
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
     * UserAgentNormalizer chain - array of \UaNormalizer\UserAgentNormalizer objects
     *
     * @var NormalizerInterface[]
     */
    private array $normalizers = [];

    /**
     * Set the User Agent Normalizers
     *
     * @param NormalizerInterface[] $normalizers
     */
    public function __construct(array $normalizers = [])
    {
        $this->normalizers = $normalizers;
    }

    /**
     * Adds a new UserAgent Normalizer to the chain
     */
    public function add(NormalizerInterface $normalizer): void
    {
        $this->normalizers[] = $normalizer;
    }

    /**
     * Return the number of normalizers currently registered
     *
     * @return int count
     */
    public function count(): int
    {
        return count($this->normalizers);
    }

    /**
     * Normalize the given $userAgent by passing down the chain
     * of normalizers
     *
     * @return string|null Normalized user agent
     *
     * @throws Exception
     */
    public function normalize(string $userAgent): ?string
    {
        $normalizedUserAgent = $userAgent;

        foreach ($this->normalizers as $normalizer) {
            $normalizedUserAgent = $normalizer->normalize($normalizedUserAgent);

            if (null === $normalizedUserAgent) {
                throw Exception::throw($userAgent);
            }
        }

        return $normalizedUserAgent;
    }
}
