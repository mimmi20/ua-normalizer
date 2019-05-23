<?php
/**
 * This file is part of the ua-normalizer package.
 *
 * Copyright (c) 2015-2019, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace UaNormalizerTest\Normalizer;

use PHPUnit\Framework\TestCase;
use UaNormalizer\Normalizer\Trim;

final class TrimTest extends TestCase
{
    /**
     * @var \UaNormalizer\Normalizer\Trim
     */
    private $normalizer;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->normalizer = new Trim();
    }

    /**
     * @dataProvider userAgentsDataProvider
     *
     * @param string $userAgent
     * @param string $expected
     *
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     *
     * @return void
     */
    public function testShouldNormalize(string $userAgent, string $expected): void
    {
        $found = $this->normalizer->normalize($userAgent);
        static::assertSame($expected, $found);
    }

    /**
     * @return array[]
     */
    public function userAgentsDataProvider()
    {
        return [
            [
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) ',
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko)',
            ],
        ];
    }
}
