<?php

declare(strict_types=1);

namespace chaser\stream\traits;

use chaser\stream\interfaces\part\CommonConnectionlessInterface;
use chaser\stream\interfaces\part\CommonInterface;

/**
 * 公共无连接部分特征
 *
 * @package chaser\stream\traits
 *
 * @property-read int $maxPackageSize
 *
 * @see CommonInterface
 */
trait CommonConnectionless
{
    /**
     * @inheritDoc
     */
    public static function configurations(): array
    {
        return ['maxPackageSize' => CommonConnectionlessInterface::MAX_PACKAGE_SIZE];
    }
}
