<?php

/**
 * This file is part of the ua-normalizer package.
 *
 * Copyright (c) 2015-2026, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace UaNormalizer;

use UaNormalizer\Normalizer\NormalizerChain;

/**
 * factory to create a useragent normalizer
 */
final class NormalizerFactory
{
    /**
     * builds an useragent normalizer chain
     *
     * @throws void
     *
     * @api
     */
    public function build(): NormalizerChain
    {
        return new NormalizerChain(
            [
                new Normalizer\RemoveBabelFish(),
                new Normalizer\RemoveComdirect(),
                new Normalizer\NormalizeEncode(),
                new Normalizer\RemoveComment(),
                new Normalizer\NormalizeIISLogging(),
                new Normalizer\NormalizeSpaces(),
                new Normalizer\NormalizeDoubleHash(),
                new Normalizer\RemoveEncryption(),
                new Normalizer\RemoveShy(),
                new Normalizer\RemoveHexCode(),
                new Normalizer\RemoveLocale(),
                new Normalizer\RemoveTabid(),
                new Normalizer\NormalizeMozilla(),
                new Normalizer\NormalizeAndroid(),
                new Normalizer\NormalizeKhtmlGecko(),
                new Normalizer\NormalizeWindowsNt(),
                new Normalizer\RemoveSerialNumbers(),
                new Normalizer\RemoveTransferEncoding(),
                new Normalizer\NormalizeLinux(),
                new Normalizer\RemoveBuild(),
                new Normalizer\NormalizeBrandNames(),
                new Normalizer\Trim(),
            ],
        );
    }
}
