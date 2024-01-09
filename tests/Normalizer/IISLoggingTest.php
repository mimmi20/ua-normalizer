<?php
/**
 * This file is part of the ua-normalizer package.
 *
 * Copyright (c) 2015-2024, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace UaNormalizerTest\Normalizer;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaNormalizer\Normalizer\IISLogging;

final class IISLoggingTest extends TestCase
{
    private IISLogging $normalizer;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @throws void
     */
    protected function setUp(): void
    {
        $this->normalizer = new IISLogging();
    }

    /** @throws ExpectationFailedException */
    #[DataProvider('userAgentsDataProvider')]
    public function testNormalize(string $userAgent, string $expected): void
    {
        $found = $this->normalizer->normalize($userAgent);
        self::assertSame($expected, $found);
    }

    /**
     * @return array<int, array<int, string>>
     *
     * @throws void
     */
    public static function userAgentsDataProvider(): array
    {
        return [
            [
                'Mozilla/4.0+(compatible;+MSIE+7.0;+Windows+NT+5.1)',
                'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)',
            ],
            [
                'Mozilla/5.0 (compatible;WI Job Roboter Spider Version 3;+http://www.webintegration.at)',
                'Mozilla/5.0 (compatible;WI Job Roboter Spider Version 3;+http://www.webintegration.at)',
            ],
            [
                'Firefox',
                'Firefox',
            ],
            [
                'Mozilla/4.0+(compatible;+Robot/1.0;zurukko640320919;)',
                'Mozilla/4.0 (compatible; Robot/1.0;zurukko640320919;)',
            ],
            [
                'Mozilla/4.0 (compatible;+Robot/1.0;zurukko640320919;)',
                'Mozilla/4.0 (compatible;+Robot/1.0;zurukko640320919;)',
            ],
            [
                'Mozilla/5.0+(compatible;+Googlebot/2.1;++http://www.google.com/bot.html) comdirect/1.0 (appVersion:19.11.0;deviceType:mobile)',
                'Mozilla/5.0+(compatible;+Googlebot/2.1;++http://www.google.com/bot.html) comdirect/1.0 (appVersion:19.11.0;deviceType:mobile)',
            ],
        ];
    }
}
