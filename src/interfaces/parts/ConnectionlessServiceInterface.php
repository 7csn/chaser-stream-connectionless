<?php

namespace chaser\stream\interfaces\parts;

/**
 * 无连接的流服务部分接口
 *
 * @package chaser\stream\interfaces\parts
 */
interface ConnectionlessServiceInterface
{
    /**
     * 默认包上限 64K-1
     */
    public const MAX_PACKAGE_SIZE = (64 << 10) - 1;
}
