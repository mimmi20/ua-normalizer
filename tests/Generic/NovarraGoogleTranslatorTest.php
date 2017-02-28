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

use UaNormalizer\Generic\NovarraGoogleTranslator;
use UaNormalizerTest\TestBase;

/**
 * Class NovarraGoogleTranslatorTest
 *
 * @group Handlers
 */
class NovarraGoogleTranslatorTest extends TestBase
{
    protected function setUp()
    {
        $this->normalizer = new NovarraGoogleTranslator();
    }

    /**
     * @test
     * @dataProvider novarraGoogleTranslatorDataProvider
     *
     * @param string $userAgent
     * @param string $expected
     */
    public function testNovarraAndGoogleTranslator($userAgent, $expected)
    {
        $found = $this->normalizer->normalize($userAgent);
        self::assertEquals($expected, $found);
    }

    public function novarraGoogleTranslatorDataProvider()
    {
        return [
            [
                'BlackBerry8310/4.2.2 Profile/MIDP-2.0 Configuration/CLDC-1.1 VendorID/125 Novarra-Vision/7.3',
                'BlackBerry8310/4.2.2 Profile/MIDP-2.0 Configuration/CLDC-1.1 VendorID/125',
            ],
            [
                'Palm750/v0100 Mozilla/4.0 (compatible; MSIE 4.01; Windows CE; PPC; 240x320),gzip(gfe) (via translate.google.com)',
                'Palm750/v0100 Mozilla/4.0 (compatible; MSIE 4.01; Windows CE; PPC; 240x320)',
            ],
            [
                'Nokia3120classic/2.0 (10.00) Profile/MIDP-2.1 Configuration/CLDC-1.1,gzip(gfe) (via translate.google.com)',
                'Nokia3120classic/2.0 (10.00) Profile/MIDP-2.1 Configuration/CLDC-1.1',
            ],
        ];
    }
}
