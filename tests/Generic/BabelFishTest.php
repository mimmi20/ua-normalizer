<?php
/**
 * This file is part of the ua-normalizer package.
 *
 * Copyright (c) 2015-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace UaNormalizerTest\Generic;

use UaNormalizer\Generic\BabelFish;

/**
 * Class LocaleRemoverTest
 *
 * @group Handlers
 */
class BabelFishTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \UaNormalizer\Generic\BabelFish
     */
    private $normalizer = null;

    protected function setUp()
    {
        $this->normalizer = new BabelFish();
    }

    /**
     * @test
     * @dataProvider userAgentsDataProvider
     *
     * @param string $userAgent
     * @param string $expected
     */
    public function testNormalize($userAgent, $expected)
    {
        $found = $this->normalizer->normalize($userAgent);
        self::assertSame($expected, $found);
    }

    public function userAgentsDataProvider()
    {
        return [
            [
                'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1) Gecko/20090624 Firefox/3.5 (.NET CLR 3.5.30729) (via babelfish.yahoo.com)',
                'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1) Gecko/20090624 Firefox/3.5 (.NET CLR 3.5.30729)',
            ],
            [
                'Firefox',
                'Firefox',
            ],
        ];
    }
}
