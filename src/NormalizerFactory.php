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

namespace UaNormalizer;

use UaNormalizer\Normalizer\NormalizerChain;

/**
 * factory to create a useragent normalizer
 */
final class NormalizerFactory
{
    /**
     * builds a useragent normalizer chain
     */
    public function build(): NormalizerChain
    {
        return new NormalizerChain(
            [
                new Normalizer\BabelFish(),
                new Normalizer\Comdirect(),
                new Normalizer\IISLogging(),
                new Normalizer\LocaleRemover(),
                new Normalizer\EncryptionRemover(),
                new Normalizer\Mozilla(),
                new Normalizer\Linux(),
                new Normalizer\KhtmlGecko(),
                new Normalizer\HexCode(),
                new Normalizer\WindowsNt(),
                new Normalizer\SerialNumbers(),
                new Normalizer\TransferEncoding(),
                new Normalizer\Trim(),
            ]
        );
    }
}
