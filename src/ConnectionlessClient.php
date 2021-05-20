<?php

declare(strict_types=1);

namespace chaser\stream;

use chaser\stream\exceptions\ClientConnectedException;
use chaser\stream\interfaces\ConnectionlessClientInterface;
use chaser\stream\traits\ConnectionlessService;
use chaser\stream\events\{Connect, Message};

/**
 * 无连接的流客户端类
 *
 * @package chaser\stream
 */
abstract class ConnectionlessClient extends Client implements ConnectionlessClientInterface
{
    use ConnectionlessService;

    /**
     * @inheritDoc
     */
    protected static int $flags = STREAM_CLIENT_CONNECT;

    /**
     * @inheritDoc
     */
    protected static int $timeout = 30;

    /**
     * 连接状态
     *
     * @var bool
     */
    protected bool $connected = false;

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
     *
     * @throws ClientConnectedException
     */
    public function connect()
    {
        if ($this->connected === false) {
            $this->create();
            stream_set_blocking($this->socket, false);
            $this->addReadReactor([$this, 'receive']);
            $this->connected = true;
            $this->dispatch(Connect::class);
        }
    }

    /**
     * @inheritDoc
     */
    public function close(): void
    {
        if ($this->socket) {
            $this->delReadReactor();
            $this->closeSocket();
            $this->connected = false;
        }
    }
}
