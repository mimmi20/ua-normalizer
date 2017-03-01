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
namespace UaNormalizer\Matcher;

/**
 * WURFL user agent matcher interface
 */
interface MatcherInterface
{
    /**
     * Attempts to find a matching $needle in given $collection within the specified $tolerance
     *
     * @param array  $collection Collection of user agents
     * @param string $needle     User agent to search for
     * @param int    $tolerance  Minimum accuracy to be considered a match
     *
     * @return string matched user agent
     */
    public function match($collection, $needle, $tolerance);
}
