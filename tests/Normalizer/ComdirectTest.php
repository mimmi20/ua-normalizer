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

namespace UaNormalizerTest\Normalizer;

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;
use UaNormalizer\Normalizer\Comdirect;
use UaNormalizer\Normalizer\Exception;

final class ComdirectTest extends TestCase
{
    private Comdirect $normalizer;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->normalizer = new Comdirect();
    }

    /**
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     * @throws Exception
     *
     * @dataProvider userAgentsDataProvider
     */
    public function testShouldNormalizeTheLinuxToken(string $userAgent, string $expected): void
    {
        $found = $this->normalizer->normalize($userAgent);
        self::assertSame($expected, $found);
    }

    /**
     * @return array<int, array<int, string>>
     */
    public function userAgentsDataProvider(): array
    {
        return [
            [
                'Mozilla/5.0+(compatible;+Googlebot/2.1;++http://www.google.com/bot.html) comdirect/1.0 (appVersion:19.11.0;deviceType:mobile)',
                'Mozilla/5.0+(compatible;+Googlebot/2.1;++http://www.google.com/bot.html)',
            ],
            [
                'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36 comdirect/1.0 (appVersion:19.6-FW-SNAPSHOT;deviceType:desktop)',
                'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36',
            ],
            [
                'Mozilla/5.0 (Linux; Android 9; Nokia 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.162 Mobile Safari/537.36 comdirect/1.0 (appVersion:20.3.0;deviceName:nokia 2;deviceType:mobile)',
                'Mozilla/5.0 (Linux; Android 9; Nokia 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.162 Mobile Safari/537.36',
            ],
            [
                'Firefox',
                'Firefox',
            ],
        ];
    }
}
