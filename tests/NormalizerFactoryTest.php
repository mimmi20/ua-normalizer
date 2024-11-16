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

namespace UaNormalizerTest;

use Override;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use UaNormalizer\Normalizer\NormalizerChain;
use UaNormalizer\NormalizerFactory;

#[Group('Handlers')]
final class NormalizerFactoryTest extends TestCase
{
    private NormalizerFactory $normalizer;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @throws void
     */
    #[Override]
    protected function setUp(): void
    {
        $this->normalizer = new NormalizerFactory();
    }

    /** @throws Exception */
    public function testBuild(): void
    {
        $chain = $this->normalizer->build();

        self::assertInstanceOf(NormalizerChain::class, $chain);
        self::assertSame(15, $chain->count());
    }
}
