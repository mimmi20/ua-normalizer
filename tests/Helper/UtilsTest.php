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
namespace UaNormalizerTest\Helper;

use UaNormalizer\Helper\Utils;

/**
 * Class UtilsTest
 *
 * @group Handlers
 */
class UtilsTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testShouldThrowExceptionForNullString()
    {
        Utils::ordinalIndexOf(null, '', 0);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testShouldThrowExceptionForEmptyString()
    {
        Utils::ordinalIndexOf('', '', 0);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testShouldThrowExceptionForNonNumericOrdinalVlaue()
    {
        Utils::ordinalIndexOf('useranget', '', '');
    }

    /**
     * @dataProvider ordinalIndexOfDataProvider
     *
     * @param string $haystack
     * @param string $needle
     * @param int    $ordinal
     * @param int    $expectedIndex
     */
    public function testOrdinalIndexOf($haystack, $needle, $ordinal, $expectedIndex)
    {
        $found = Utils::ordinalIndexOf($haystack, $needle, $ordinal);
        self::assertEquals($expectedIndex, $found);
    }

    public function testShouldReturnNegativeOneForInexistantChar()
    {
        $haystack = 'Mozilla/4.0 (compatible; MSIE 4.0; Windows 95; .NET CLR 1.1.4322; .NET CLR 2.0.50727)';
        $needle   = ':';
        $expected = Utils::ordinalIndexOf($haystack, $needle, 1);
        self::assertEquals(-1, $expected);
    }

    /**
     * @dataProvider indexOfAnyOrLengthDataProvider
     *
     * @param string $haystack
     * @param string $expected
     */
    public function testIndexOfAnyOrLength($haystack, $expected)
    {
        $found = Utils::indexOfAnyOrLength($haystack, [' ', '/'], 0);
        self::assertEquals($expected, $found);
    }

    public static function indexOfAnyOrLengthDataProvider()
    {
        return [
            ['aab/ ', 3],
            ['aab / ', 3],
            ['aab', 3],
        ];
    }

    public static function ordinalIndexOfOrLengthDataProvider()
    {
        return [
            ['Mozilla/4.0 (compatible; MSIE 6.0; Windows CE; IEMobile 6.9) VZW:SCH-i760 PPC 240x320', '/', 1, 7],
            [
                'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727; InfoPath.1; .NET CLR 1.1.4322)',
                ';',
                1,
                23,
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727; InfoPath.1; .NET CLR 1.1.4322)',
                ';',
                2,
                33,
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727; InfoPath.1; .NET CLR 1.1.4322)',
                ';',
                3,
                49,
            ],
            ['Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1)', '/', 1, 7],
            ['Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0; GoodAccess 3.7.0.9 (PalmOS 5.1))', ';', 4, -1],
        ];
    }

    public static function ordinalIndexOfDataProvider()
    {
        return [
            ['Mozilla/4.0 (compatible; MSIE 6.0; Windows CE; IEMobile 6.9) VZW:SCH-i760 PPC 240x320', '/', 1, 7],
            [
                'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727; InfoPath.1; .NET CLR 1.1.4322)',
                ';',
                1,
                23,
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727; InfoPath.1; .NET CLR 1.1.4322)',
                ';',
                2,
                33,
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727; InfoPath.1; .NET CLR 1.1.4322)',
                ';',
                3,
                49,
            ],
            ['Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1)', '/', 1, 7],
            ['Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0; GoodAccess 3.7.0.9 (PalmOS 5.1))', ';', 4, -1],
        ];
    }

    public static function userAgentsWithThirdSemiColumn()
    {
        return [
            ['Mozilla/4.0 (compatible; MSIE 6.0; Windows CE; IEMobile 6.9) VZW:SCH-i760 PPC 240x320', 38],
            [
                'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727; InfoPath.1; .NET CLR 1.1.4322)',
                42,
            ],
            ['Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1)', 42],
        ];
    }
}
