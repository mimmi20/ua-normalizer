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
 * User Agent Normalizer
 * Return the safari user agent stripping out
 *     - all the chararcters between U; and Safari/xxx
 *
 *  e.g Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_4_11; fr) ... Version/3.1.1 Safari/525.18
 *         becomes
 *         Mozilla/5.0 (Macintosh Safari/525
 */
class Opera implements NormalizerInterface
{
    /**
     * @param string $userAgent
     *
     * @return string
     */
    public function normalize($userAgent)
    {
        $s = \Stringy\create($userAgent);

        // Repair Opera user agents using fake version 9.80
        // Normalize: Opera/9.80 (X11; Linux x86_64; U; sv) Presto/2.9.168 Version/11.50
        // Into: Opera/11.50 (X11; Linux x86_64; U; sv) Presto/2.9.168 Version/11.50
        if ($s->startsWith('Opera/9.80')) {
            if (preg_match('#Version/(\d+\.\d+)#', $userAgent, $matches)) {
                $userAgent = str_replace('Opera/9.80', 'Opera/' . $matches[1], $userAgent);
            }

            //Match to the '.' in the Opera version number
            return $userAgent;
        }
        //Normalize Opera v15 and above UAs, that say OPR, into 'Opera/version UA' format used above
        if (preg_match('#OPR/(\d+\.\d+)#', $userAgent, $matches)) {
            $prefix    = 'Opera/' . $matches[1] . ' ';
            $userAgent = $prefix . $userAgent;
        }

        return $userAgent;
    }
}
