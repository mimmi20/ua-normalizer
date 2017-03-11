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
namespace UaNormalizerTest;

/**
 * Class TestBase
 *
 * @group Handlers
 */
class TestBase extends \PHPUnit\Framework\TestCase
{
    /** @var \UaNormalizer\NormalizerInterface */
    protected $normalizer;

    public function assertNormalizeEqualsExpected($userAgent, $expected)
    {
        $actual = $this->normalizer->normalize($userAgent);
        self::assertEquals($expected, $actual, $userAgent);
    }

    protected function userAgentsProvider($testFilePath)
    {
        $fullTestFilePath = __DIR__ . DIRECTORY_SEPARATOR . $testFilePath;
        $useragents       = file($fullTestFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $map              = [];
        foreach ($useragents as $useragent) {
            $map[] = explode('=', $useragent);
        }

        return $map;
    }
}
