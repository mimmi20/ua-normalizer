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

use UaNormalizer\Generic\Tokens;

/**
 * Class LocaleRemoverTest
 *
 * @group Handlers
 */
class TokensTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \UaNormalizer\Generic\Tokens
     */
    private $normalizer = null;

    protected function setUp()
    {
        $this->normalizer = new Tokens();
    }

    /**
     * @test
     * @dataProvider userAgentsDataProvider
     *
     * @param string $userAgent
     * @param string $expected
     */
    public function shouldNormalizeTheDamagedToken($userAgent, $expected)
    {
        $found = $this->normalizer->normalize($userAgent);
        self::assertSame($expected, $found);
    }

    public function userAgentsDataProvider()
    {
        return [
            [
                'Mozilla/5.0 (Mobile; Windows Phone 8.1; Android 4.0; ARM; Trident/7.0; Touch; rv:11.0EMobile/11.0; NOKIA; Lumia 520; Orange) like iPhone OS 7_0_3 Mac OS X AppleWebKit/537 (KHTML, like Gecko) Mobile Safari/537',
                'Mozilla/5.0 (Mobile; Windows Phone 8.1; Android 4.0; ARM; Trident/7.0; Touch; rv:11.0; IEMobile/11.0; NOKIA; Lumia 520; Orange) like iPhone OS 7_0_3 Mac OS X AppleWebKit/537 (KHTML, like Gecko) Mobile Safari/537',
            ],
            [
                'Mozilla/5.0 (Macintoshntel Mac OS X) AppleWebKit/528.16 (KHTML, like Gecko, Safari/528.16) OmniWeb/v622.8.0.112941',
                'Mozilla/5.0 (Macintosh; Intel Mac OS X) AppleWebKit/528.16 (KHTML, like Gecko, Safari/528.16) OmniWeb/v622.8.0.112941',
            ],
            [
                'QuickTime.7.0.4 (qtver=7.0.4;cpu=PPC=Mac 10.3.9)',
                'QuickTime.7.0.4 (qtver=7.0.4;cpu=PPC;os=Mac 10.3.9)',
            ],
            [
                'Mozilla/5\\.0 (Windows; U; Windows NT 6.1; de; rv:1.9.2.6) Gecko/20100625 Firefox/3.6.6 ( .NET CLR 3.5.30729)',
                'Mozilla/5.0 (Windows; U; Windows NT 6.1; de; rv:1.9.2.6) Gecko/20100625 Firefox/3.6.6 ( .NET CLR 3.5.30729)',
            ],
            [
                'Mozilla/5.0 (X11buntu; Linux i686 on x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2477.8 Safari/537.36',
                'Mozilla/5.0 (X11; Ubuntu; Linux i686 on x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2477.8 Safari/537.36',
            ],
            [
                'Mozilla',
                'Mozilla',
            ],
            [
                'Firefox',
                'Firefox',
            ],
        ];
    }
}
