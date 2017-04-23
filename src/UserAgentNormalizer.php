<?php
/**
 * This file is part of the ua-normalizer package.
 *
 * Copyright (c) 2015-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace UaNormalizer;

/**
 * User Agent Normalizer
 */
class UserAgentNormalizer implements NormalizerInterface
{
    /**
     * UserAgentNormalizer chain - array of \UaNormalizer\UserAgentNormalizer objects
     *
     * @var \UaNormalizer\NormalizerInterface[]
     */
    private $normalizers = [];

    /**
     * Set the User Agent Normalizers
     *
     * @param \UaNormalizer\NormalizerInterface[] $normalizers
     */
    public function __construct(array $normalizers = [])
    {
        $this->normalizers = $normalizers;
    }

    /**
     * Adds a new UserAgent Normalizer to the chain
     *
     * @param \UaNormalizer\NormalizerInterface $normalizer
     *
     * @return UserAgentNormalizer
     */
    public function add(NormalizerInterface $normalizer)
    {
        $this->normalizers[] = $normalizer;

        return $this;
    }

    /**
     * Return the number of normalizers currently registered
     *
     * @return int count
     */
    public function count()
    {
        return count($this->normalizers);
    }

    /**
     * Normalize the given $userAgent by passing down the chain
     * of normalizers
     *
     * @param string $userAgent
     *
     * @return string Normalized user agent
     */
    public function normalize($userAgent)
    {
        $normalizedUserAgent = $userAgent;

        foreach ($this->normalizers as $normalizer) {
            /* @var $normalizer \UaNormalizer\NormalizerInterface */
            $normalizedUserAgent = $normalizer->normalize($normalizedUserAgent);
        }

        return $normalizedUserAgent;
    }
}
