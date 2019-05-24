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
namespace UaNormalizerTest;

use PHPUnit\Framework\TestCase;
use UaNormalizer\Normalizer\NormalizerChain;
use UaNormalizer\NormalizerFactory;

/**
 * Class LocaleRemoverTest
 *
 * @group Handlers
 */
final class NormalizerFactoryTest extends TestCase
{
    /**
     * @var \UaNormalizer\NormalizerFactory
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
        $this->normalizer = new NormalizerFactory();
    }

    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     *
     * @return void
     */
    public function testNormalize(): void
    {
        self::assertInstanceOf(NormalizerChain::class, $this->normalizer->build());
    }
}
