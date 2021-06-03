<?php

declare(strict_types=1);

namespace chaser\stream;

use chaser\stream\event\AcceptData;
use chaser\stream\interfaces\part\ConnectionlessServiceInterface;

/**
 * 无连接的流服务器
 *
 * @package chaser\stream
 *
 * @property int $maxPackageSize
 */
abstract class ConnectionlessServer extends Server implements ConnectionlessServiceInterface
{
    /**
     * @inheritDoc
     */
    protected static int $flags = STREAM_SERVER_BIND;

    /**
     * @inheritDoc
     */
    public function configurations(): array
    {
        return ['maxPackageSize' => self::MAX_PACKAGE_SIZE] + parent::configurations();
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
        return strlen($data) === stream_socket_sendto($this->socket, $data, 0, $remoteAddress);
    }
}
