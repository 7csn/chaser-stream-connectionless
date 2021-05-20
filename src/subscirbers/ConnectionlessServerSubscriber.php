<?php

declare(strict_types=1);

namespace chaser\stream\subscribers;

use chaser\container\ContainerInterface;
use chaser\stream\events\AcceptData;
use chaser\stream\interfaces\ConnectionlessServerInterface;

/**
 * 无连接的流服务器事件订阅类
 *
 * @package chaser\stream\subscribers
 *
 * @property ConnectionlessServerInterface $server
 */
class ConnectionlessServerSubscriber extends ServerSubscriber
{
    /**
     * 构造方法
     *
     * @param ContainerInterface $container
     * @param ConnectionlessServerInterface $server
     */
    public function __construct(ContainerInterface $container, ConnectionlessServerInterface $server)
    {
        parent::__construct($container, $server);
    }

    /**
     * @inheritDoc
     */
    public static function events(): array
    {
        return [AcceptData::class => 'accept'] + parent::events();
    }

    /**
     * 接收数据事件响应
     *
     * @param AcceptData $event
     */
    public function accept(AcceptData $event): void
    {
    }
}
