<?php

namespace chaser\stream\traits;

use chaser\stream\interfaces\parts\ConnectionlessServiceInterface;

/**
 * 无连接的流服务特征
 *
 * @package chaser\stream\traits
 *
 * @property int $maxPackageSize
 *
 * @see ConnectionlessServiceInterface
 */
trait ConnectionlessService
{
    /**
     * @inheritDoc
     */
    protected function configurations(): array
    {
        return ['maxPackageSize' => self::MAX_PACKAGE_SIZE];
    }
}
