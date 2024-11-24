<?php
namespace App\Tests\Unit\Cqrs\Handler;

use App\Cqrs\Handler\GoalsCommandHandler;
use App\Cqrs\Command\CreateGoalsCommand;
use App\Repository\GoalsRepository;
use App\Service\TaskService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Uid\Uuid;
use App\Entity\Goals;

class GoalsCommandHandlerTest extends TestCase
{
private $repository;
private $taskService;
private $bus;
private $handler;

protected function setUp(): void
{
// Мокирование репозитория и сервиса
$this->repository = $this->createMock(GoalsRepository::class);
$this->taskService = $this->createMock(TaskService::class);
$this->bus = $this->createMock(MessageBusInterface::class);

// Инициализация хэндлера с мок-объектами
$this->handler = new GoalsCommandHandler($this->repository, $this->bus, $this->taskService);
}

public function testHandleCreate(): void
{
// Данные для команды
$entityData = [
'title' => 'New Task',
'priority' => 1,
'is_main' => true,
'type' => 2,
'is_complete' => false,
'user_uuid' => Uuid::fromString('dde6ec84-de4a-4b59-bfa0-68e92f7aa805'),
'created_at' => new \DateTimeImmutable(),
];

// Создание команды
$command = new CreateGoalsCommand($entityData);

// Мокирование методов репозитория для проверки вызовов
$this->repository->expects($this->once())
->method('save')
->with($this->callback(function (Goals $goal) use ($entityData) {
// Проверяем, что данные правильно переданы в сущность
return $goal->getTitle() === $entityData['title']
&& $goal->getPriority() === $entityData['priority']
&& $goal->IsMain() === $entityData['is_main']
&& $goal->IsComplete() === $entityData['is_complete']
&& $goal->getUserUuid()->equals($entityData['user_uuid']);
}));

// Мокирование метода TaskService для проверки его вызова
$this->taskService->expects($this->once())
->method('createTask')
->with($this->callback(function ($taskData) use ($entityData) {
return $taskData['uuid'] instanceof Uuid
&& $taskData['user_uuid']->equals($entityData['user_uuid']);
}));

// Вызываем метод handleCreate хэндлера
$this->handler->handleCreate($command);
}
}
