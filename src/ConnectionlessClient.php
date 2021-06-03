<?php

declare(strict_types=1);

namespace chaser\stream;

use chaser\stream\interfaces\part\ConnectionlessServiceInterface;
use chaser\stream\event\Message;

/**
 * 无连接的流客户端类
 *
 * @package chaser\stream
 *
 * @property int $maxPackageSize
 */
abstract class ConnectionlessClient extends Client implements ConnectionlessServiceInterface
{
    /**
     * @inheritDoc
     */
    protected static int $flags = STREAM_CLIENT_CONNECT;

    /**
     * @inheritDoc
     */
    protected static int $timeout = 30;

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
    public function ready(): void
    {
        if ($this->socket === null) {
            $this->create();
            stream_set_blocking($this->socket, false);
            $this->readyHandle();
        }
    }

    /**
     * @inheritDoc
     */
    public function receive(): void
    {
        $receive = stream_socket_recvfrom($this->socket, $this->maxPackageSize);
        if ($receive) {
            $this->dispatch(Message::class, $receive);
        }
    }

    /**
     * @inheritDoc
     */
    public function send(string $data): bool
    {
        return strlen($data) === stream_socket_sendto($this->socket, $data);
    }

    /**
     * @inheritDoc
     */
    public function close(): void
    {
        if ($this->socket) {
            $this->delReadReact();
            $this->closeSocket();
        }
    }
}
