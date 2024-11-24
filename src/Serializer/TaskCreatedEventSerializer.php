<?php

namespace App\Serializer;

use Symfony\Component\Serializer\SerializerInterface;
use App\Message\TaskCreatedEvent;

class TaskCreatedEventSerializer
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function serialize(TaskCreatedEvent $event): string
    {
        return $this->serializer->serialize($event, 'json');
    }
}
