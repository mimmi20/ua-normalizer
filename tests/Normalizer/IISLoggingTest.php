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
use UaNormalizer\Normalizer\Exception;
use UaNormalizer\Normalizer\IISLogging;

final class IISLoggingTest extends TestCase
{
    private IISLogging $normalizer;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->normalizer = new IISLogging();
    }

    /**
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     * @throws Exception
     *
     * @dataProvider userAgentsDataProvider
     */
    public function testNormalize(string $userAgent, string $expected): void
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
        ];
    }
}
