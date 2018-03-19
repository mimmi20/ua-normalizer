<?php
/**
 * This file is part of the ua-normalizer package.
 *
 * Copyright (c) 2015-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace UaNormalizer;

use UaNormalizer\Normalizer\UserAgentNormalizer;

/**
 * factory to create a useragent normalizer
 */
class NormalizerFactory
{
    /**
     * builds a useragent normalizer chain
     *
     * @return \UaNormalizer\Normalizer\UserAgentNormalizer
     */
    public function build(): UserAgentNormalizer
    {
        return new UserAgentNormalizer(
            [
                new Normalizer\BabelFish(),
                new Normalizer\IISLogging(),
                new Normalizer\LocaleRemover(),
                new Normalizer\EncryptionRemover(),
                new Normalizer\Mozilla(),
                new Normalizer\Linux(),
                new Normalizer\KhtmlGecko(),
                new Normalizer\HexCode(),
                new Normalizer\WindowsNt(),
                new Normalizer\Tokens(),
                new Normalizer\SerialNumbers(),
                new Normalizer\TransferEncoding(),
            ]
        );
    }
}
