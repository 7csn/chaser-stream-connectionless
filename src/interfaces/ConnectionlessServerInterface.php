<?php

namespace chaser\stream\interfaces;

use chaser\stream\interfaces\parts\ConnectionlessServiceInterface;

/**
 * 无连接的流服务器接口
 *
 * @package chaser\stream\interfaces
 */
interface ConnectionlessServerInterface extends ConnectionlessServiceInterface, ServerInterface
{
    /**
     * 发送数据到指定客户端地址
     *
     * @param string $data
     * @param string $remoteAddress
     * @return bool
     */
    public function send(string $data, string $remoteAddress): bool;
}
