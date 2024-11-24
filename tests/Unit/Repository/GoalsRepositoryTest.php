<?php

namespace App\Tests\Unit\Repository;

use Doctrine\Persistence\ManagerRegistry;
use App\Repository\GoalsRepository;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use App\Entity\Goals;

class GoalsRepositoryTest extends TestCase
{
    private $entityManager;
    private $repository;
    private $registry;

    protected function setUp(): void
    {
        // Создаем мок EntityManager
        $this->entityManager = $this->createMock(EntityManagerInterface::class);

        // Создаем мок ManagerRegistry
        $this->registry = $this->createMock(ManagerRegistry::class);

        // Настраиваем registry, чтобы он возвращал наш EntityManager
        $this->registry->method('getManagerForClass')
            ->with(Goals::class)
            ->willReturn($this->entityManager);

        // Инициализируем тестируемый репозиторий
        $this->repository = new GoalsRepository($this->registry, $this->entityManager);
    }

    public function testSaveGoal(): void
    {
        // Мокируем цель (entity)
        $goal = $this->createMock(Goals::class);

        // Ожидание вызова методов persist() и flush() в EntityManager
        $this->entityManager->expects($this->once())
            ->method('persist')
            ->with($goal);

        $this->entityManager->expects($this->once())
            ->method('flush');

        // Вызов метода save в репозитории
        $this->repository->save($goal);
    }

    public function testDeleteGoal(): void
    {
        $goal = $this->createMock(Goals::class);

        // Ожидание вызова методов remove() и flush() в EntityManager
        $this->entityManager->expects($this->once())
            ->method('remove')
            ->with($goal);

        $this->entityManager->expects($this->once())
            ->method('flush');

        // Вызов метода delete в репозитории
        $this->repository->delete($goal);
    }
}
