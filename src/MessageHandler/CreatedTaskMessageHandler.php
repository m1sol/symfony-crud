<?php

namespace App\MessageHandler;

use App\Message\TaskCreatedEvent;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreatedTaskMessageHandler
{
    public function __invoke(TaskCreatedEvent $message)
    {
        // Обработка сообщения
        echo $message->getContent();
    }
}