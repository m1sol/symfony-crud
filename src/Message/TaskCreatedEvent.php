<?php
namespace App\Message;

use Symfony\Component\Uid\Uuid;

class TaskCreatedEvent
{
    private string $taskUuid;
    private string $userUuid;

    public function __construct(Uuid $taskUuid, Uuid $userUuid)
    {
        // Преобразуем UUID в строку для передачи между микросервисами
        $this->taskUuid = (string) $taskUuid;
        $this->userUuid = (string) $userUuid;
    }

    public function getTaskUuid(): string
    {
        return $this->taskUuid;
    }

    public function getUserUuid(): string
    {
        return $this->userUuid;
    }

    public function getContent(): string
    {
        return json_encode([
            'task_uuid' => $this->taskUuid,
            'user_uuid' => $this->userUuid,
        ]);
    }

    public function __serialize(): array
    {
        return [
            'taskUuid' => $this->taskUuid,
            'userUuid' => $this->userUuid,
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->taskUuid = $data['taskUuid'];
        $this->userUuid = $data['userUuid'];
    }
}
