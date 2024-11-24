<?php
namespace App\Service;

use App\Message\TaskCreatedEvent;
use App\Producer\TaskEventProducer;
use App\Serializer\TaskCreatedEventSerializer;

class TaskService
{
private TaskEventProducer $taskEventProducer;


public function __construct(
    TaskEventProducer $taskEventProducer
)
{
    $this->taskEventProducer = $taskEventProducer;
}

public function createTask($taskData)
{
// Создание события
$event = new TaskCreatedEvent($taskData['uuid'], $taskData['user_uuid']);

// Отправка события в RabbitMQ
    $this->taskEventProducer->publish($event);
}
}
