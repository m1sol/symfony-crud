<?php

namespace App\Tests\Unit\Cqrs\Command;

use App\Cqrs\Command\CreateGoalsCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class CreateGoalsCommandTest extends TestCase
{
    public function testCreateGoalsCommandWithValidData(): void
    {
        $entityData = [
            "title" => "New Task",
            "priority" => 1,
            "is_main" => true,
            "type" => 2,
            "is_complete" => false,
            "user_uuid" => Uuid::fromString('dde6ec84-de4a-4b59-bfa0-68e92f7aa805')
        ];

        $command = new CreateGoalsCommand($entityData);
        $this->assertEquals('New Task', $command->getTitle());
        $this->assertEquals(1, $command->getPriority());
        $this->assertEquals(true, $command->getIsMain());
        $this->assertEquals(false, $command->getIsComplete());
        $this->assertInstanceOf(\DateTimeImmutable::class, $command->getCreatedAt());
        $this->assertEquals($entityData, $command->toArray());
    }
}