<?php

namespace chaser\stream\interfaces\part;

/**
 * 流服务公共无连接部分接口
 *
 * @package chaser\stream\interfaces\part
 */
interface CommonConnectionlessInterface
{
    /**
     * 默认包上限 64K-1
     */
    public const MAX_PACKAGE_SIZE = (64 << 10) - 1;
}
