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
namespace UaNormalizer\Specific;

use UaNormalizer\NormalizerInterface;

/**
 * User Agent Normalizer - MSIE String with the Major and Minor Version Only.
 */
class MSIE implements NormalizerInterface
{
    /**
     * @param string $userAgent
     *
     * @return string
     */
    public function normalize($userAgent)
    {
        return $this->msieWithVersion($userAgent);
    }

    /**
     * Returns version info
     *
     * @param string $userAgent
     *
     * @return string Version info
     */
    private function msieWithVersion($userAgent)
    {
        return preg_replace(
            '/( \.NET CLR [\d\.]+;?| Media Center PC [\d\.]+;?| OfficeLive[a-zA-Z0-9\.\d]+;?| InfoPath[\.\d]+;?)/',
            '',
            $userAgent
        );
    }
}
