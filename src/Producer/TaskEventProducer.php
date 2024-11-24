<?php

namespace App\Producer;

use App\Message\TaskCreatedEvent;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;

class TaskEventProducer
{
    private MessageBusInterface $bus;

    public function __construct(
        MessageBusInterface $bus
    )
    {
        $this->bus = $bus;
    }

    public function publish(TaskCreatedEvent $event): void
    {
        // Отправка события в очередь через Symfony Messenger
        $this->bus->dispatch($event, [new AmqpStamp('task.created')]);
    }
}
