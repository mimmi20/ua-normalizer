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
namespace UaNormalizerTest\Matcher;

/*
 * test case
 */
use UaNormalizer\Matcher\RISMatcher;

/**
 * Class RISMatcherTest
 *
 * @group Handlers
 */
class RISMatcherTest extends \PHPUnit_Framework_TestCase
{
    /** @var \UaNormalizer\Matcher\RISMatcher */
    private $risMatcher;

    protected function setUp()
    {
        $this->risMatcher = RISMatcher::getInstance();
    }

    /**
     * @dataProvider risData
     *
     * @param array  $candidates
     * @param string $needle
     * @param int    $tolerance
     * @param string $expected
     */
    public function testMatch($candidates, $needle, $tolerance, $expected)
    {
        $result = $this->risMatcher->match($candidates, $needle, $tolerance);
        self::assertEquals($expected, $result);
    }

    public function testMatchMustReturnFirstMatch()
    {
        $expected = 'aaa bbb 1';
        $needle   = 'aaa bbb 4';

        $candidates = ['aaa bbb 1', 'aaa bbb 2', 'aaa bbb 3', 'aaa bbb 5', 'aaa bbb 6'];

        $match = $this->risMatcher->match($candidates, $needle, 1);

        self::assertEquals($expected, $match);
    }

    public function risData()
    {
        $candidates = ['aaa bbb ccc ddd', 'aaa bbb ccc', 'aaa bbb', 'aaa', 'aaa xxx'];
        sort($candidates);

        return [
            [$candidates, 'aaa bbb ccc ddd', 15, 'aaa bbb ccc ddd'],
            [$candidates, 'aaa bbb ccc xxx', 15, null],
            [$candidates, 'aaa bbb ccc', 11, 'aaa bbb ccc'],
            [$candidates, 'aaa bbb ccc ddd', 3, 'aaa bbb ccc ddd'],
        ];
    }
}
