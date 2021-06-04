<?php

declare(strict_types=1);

namespace chaser\stream;

use chaser\stream\event\Message;
use chaser\stream\traits\CommonConnectionless;

/**
 * 无连接的流客户端类
 *
 * @package chaser\stream
 */
abstract class ConnectionlessClient extends Client
{
    use CommonConnectionless;

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
    public static function configurations(): array
    {
        return CommonConnectionless::configurations() + parent::configurations();
    }

    /**
     * @inheritDoc
     */
    public function ready(): void
    {
        if ($this->socket === null) {
            $this->create();
            $this->configureSocket();
            $this->readyHandle();
        }
    }

    /**
     * @inheritDoc
     */
    public function receive(): void
    {
        if ($this->socket) {
            $receive = stream_socket_recvfrom($this->socket, $this->maxPackageSize);
            if ($receive) {
                $this->dispatch(Message::class, $receive);
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function send(string $data): bool
    {
        return $this->socket === null ? false : strlen($data) === stream_socket_sendto($this->socket, $data);
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

    /**
     * 配置套接字
     */
    protected function configureSocket(): void
    {
        // 非阻塞模式
        stream_set_blocking($this->socket, false);
    }
}
