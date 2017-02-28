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
namespace UaNormalizer\Generic;

use UaNormalizer\NormalizerInterface;

/**
 * User Agent Normalizer - removes BabelFish garbage from user agent
 */
class BabelFish implements NormalizerInterface
{
    /**
     * @var string
     */
    const BABEL_FISH_REGEX = '/\\s*\\(via babelfish.yahoo.com\\)\\s*/';

    /**
     * @param string $userAgent
     *
     * @return mixed|string
     */
    public function normalize($userAgent)
    {
        return preg_replace(self::BABEL_FISH_REGEX, '', $userAgent);
    }
}
