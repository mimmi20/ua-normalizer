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
namespace UaNormalizer\Normalizer;

use Safe\Exceptions\SafeExceptionInterface;
use Safe\Exceptions\StringsException;
use function Safe\sprintf;

final class Exception extends \UnexpectedValueException
{
    /**
     * @param string                                       $userAgent
     * @param \Safe\Exceptions\SafeExceptionInterface|null $e
     *
     * @return self
     */
    public static function throw(string $userAgent, SafeExceptionInterface $e = null): self
    {
        try {
            $message = sprintf('an error occurecd while normalizing useragent "%s"', $userAgent);
        } catch (StringsException $ex) {
            $message = 'an error occurecd while normalizing an useragent followed by an exception while generating the exception message';
            $e       = new \Exception($ex->getMessage(), 0, $e);
        }

        return new self($message, 0, $e);
    }
}
