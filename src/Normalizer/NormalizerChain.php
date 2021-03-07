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
     * @var \UaNormalizer\Normalizer\NormalizerInterface[]
     */
    private $normalizers = [];

    /**
     * Set the User Agent Normalizers
     *
     * @param \UaNormalizer\Normalizer\NormalizerInterface[] $normalizers
     */
    public function __construct(array $normalizers = [])
    {
        $this->normalizers = $normalizers;
    }

    /**
     * Adds a new UserAgent Normalizer to the chain
     *
     * @param \UaNormalizer\Normalizer\NormalizerInterface $normalizer
     *
     * @return void
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
     * @param string $userAgent
     *
     * @throws Exception
     *
     * @return string Normalized user agent
     */
    public function normalize(string $userAgent): string
    {
        $normalizedUserAgent = $userAgent;

        foreach ($this->normalizers as $normalizer) {
            $normalizedUserAgent = $normalizer->normalize($normalizedUserAgent);
        }

        return $normalizedUserAgent;
    }
}
