<?php

declare(strict_types=1);

namespace chaser\stream;

use chaser\stream\event\AcceptData;
use chaser\stream\subscriber\ConnectionlessServerSubscriber;
use chaser\stream\traits\CommonConnectionless;

/**
 * 无连接的流服务器
 *
 * @package chaser\stream
 */
abstract class ConnectionlessServer extends Server
{
    use CommonConnectionless;

    /**
     * @inheritDoc
     */
    protected static int $flags = STREAM_SERVER_BIND;

    /**
     * @inheritDoc
     */
    public static function subscriber(): string
    {
        return ConnectionlessServerSubscriber::class;
    }

    /**
     * @inheritDoc
     */
    public static function configurations(): array
    {
        return CommonConnectionless::configurations() + parent::configurations();
    }

    /**
     * @inheritDoc
     */
    public function accept(): void
    {
        $receive = stream_socket_recvfrom($this->socket, $this->maxPackageSize, 0, $remoteAddress);

        if ($receive !== false && !empty($remoteAddress)) {
            $this->dispatch(AcceptData::class, $receive, $remoteAddress);
        }
    }

    /**
     * 发送数据到指定客户端
     *
     * @param string $data
     * @param string $remoteAddress
     * @return bool
     */
    public function send(string $data, string $remoteAddress): bool
    {
        return $this->socket === null
            ? false
            : strlen($data) === stream_socket_sendto($this->socket, $data, 0, $remoteAddress);
    }
}
