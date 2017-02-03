<?php
/**
 * Copyright (c) 2015 ScientiaMobile, Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * Refer to the LICENSE file distributed with this package.
 *
 *
 * @category   WURFL
 *
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 */

namespace UaNormalizer;

/**
 * User Agent Normalizer
 */
class UserAgentNormalizer implements NormalizerInterface
{
    /**
     * UserAgentNormalizer chain - array of \UaNormalizer\UserAgentNormalizer objects
     *
     * @var array
     */
    protected $normalizers = [];

    /**
     * Set the User Agent Normalizers
     *
     * @param array $normalizers Array of \UaNormalizer\UserAgentNormalizer objects
     */
    public function __construct($normalizers = [])
    {
        if (is_array($normalizers)) {
            $this->normalizers = $normalizers;
        }
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
