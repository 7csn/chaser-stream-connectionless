<?php

declare(strict_types=1);

namespace chaser\stream;

use chaser\stream\events\AcceptData;
use chaser\stream\interfaces\ConnectionlessServerInterface;
use chaser\stream\traits\ConnectionlessService;

/**
 * 无连接的流服务器
 *
 * @package chaser\stream
 */
abstract class ConnectionlessServer extends Server implements ConnectionlessServerInterface
{
    use ConnectionlessService;

    /**
     * @inheritDoc
     */
    protected static int $flags = STREAM_SERVER_BIND;

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
     * @inheritDoc
     */
    public function send(string $data, string $remoteAddress): bool
    {
        return strlen($data) === stream_socket_sendto($this->socket, $data, 0, $remoteAddress);
    }
}
