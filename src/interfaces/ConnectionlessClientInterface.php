<?php

namespace chaser\stream\interfaces;

use chaser\stream\interfaces\parts\ConnectionlessServiceInterface;

/**
 * 无连接的流客户端接口
 *
 * @package chaser\stream\interfaces
 */
interface ConnectionlessClientInterface extends ClientInterface, ConnectionlessServiceInterface
{
}
