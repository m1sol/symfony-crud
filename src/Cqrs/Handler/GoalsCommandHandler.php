<?php

namespace App\Cqrs\Handler;

use App\Abstract\AbstractCommandHandler;
use App\Repository\GoalsRepository;
use App\Contract\CommandInterface;
use App\Entity\Goals;
use App\Service\TaskService;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Messenger\MessageBusInterface;

class GoalsCommandHandler extends AbstractCommandHandler
{
    private MessageBusInterface $bus;
    private GoalsRepository $repository;
    private TaskService $taskService;

    public function __construct(
        GoalsRepository $repository,
        MessageBusInterface $bus,
        TaskService $taskService
    )
    {
        $this->repository = $repository;
        $this->bus = $bus;
        $this->taskService = $taskService;
    }

    public function handleCreate(CommandInterface $command)
    {
        $data = $command->getEntityData();
        $goal = new Goals();
        $goal->setUuid(Uuid::v4());
        $goal->setName($data['name']);
        $goal->setPriority($data['priority']);
        $goal->setMain($data['is_main']);
        $goal->setComplete($data['is_complete']);
        $goal->setCreatedAt($data['created_at']);
        $goal->setType($data['type']);
        $goal->setUserUuid($data['user_uuid']);
        $this->repository->save($goal);
        $this->taskService->createTask(['uuid' => $goal->getUuid(), 'user_uuid' => Uuid::fromString($data['user_uuid'])]);
    }
    public function handleUpdate($uuid, CommandInterface $command)
    {}
    public function handleDelete($uuid)
    {}

    private function sendCreatedMessage(): void
    {
        $message = new TaskCreateMessage('Hello, RabbitMQ!');
        $this->bus->dispatch($message);
    }
//    public function handleUpdate($id, CommandInterface $command)
//    {
//        $user = $this->repository->find($id);
//        if (!$user) {
//            throw new \Exception("User not found");
//        }
//        $data = $command->getEntityData();
//        if (isset($data['login'])) {
//            $user->setLogin($data['login']);
//        }
//        if (isset($data['email'])) {
//            $user->setEmail($data['email']);
//        }
//        if (isset($data['password'])) {
//            $user->setPassword($this->passwordHasher->hashPassword($user, $data['password']));
//        }
//        if (isset($data['roles'])) {
//            $user->setRoles($data['roles']);
//        }
//        $this->repository->save($user);
//    }
//
//    public function handleDelete($id)
//    {
//        $user = $this->repository->find($id);
//        if (!$user) {
//            throw new \Exception("User not found");
//        }
//        $this->repository->delete($user);
//    }
}