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

namespace UaNormalizerTest;

use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;
use UaNormalizer\Normalizer\NormalizerChain;
use UaNormalizer\NormalizerFactory;

/**
 * @group Handlers
 */
final class NormalizerFactoryTest extends TestCase
{
    private NormalizerFactory $normalizer;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->normalizer = new NormalizerFactory();
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testNormalize(): void
    {
        $chain = $this->normalizer->build();

        self::assertInstanceOf(NormalizerChain::class, $chain);
        self::assertSame(13, $chain->count());
    }
}
