<?php

declare(strict_types=1);

namespace chaser\stream\event;

use chaser\stream\traits\PropertyReadable;

/**
 * 服务器接收数据事件类
 *
 * @package chaser\stream\event
 *
 * @property-read string $data
 * @property-read string $remoteAddress
 */
class AcceptData
{
    use PropertyReadable;

    /**
     * 初始化数据
     *
     * @param string $data
     * @param string $remoteAddress
     */
    public function __construct(private string $data, private string $remoteAddress)
    {
    }
}
