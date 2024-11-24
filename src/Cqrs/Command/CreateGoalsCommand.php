<?php

namespace App\Cqrs\Command;

use App\Abstract\AbstractCommand;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

class CreateGoalsCommand extends AbstractCommand
{
    #[Assert\NotBlank]
    #[Assert\Uuid]
    private Uuid $uuid;

    #[Assert\NotBlank]
    private string $name;

    #[Assert\Choice([0, 1, 2, 3])]
    private int $priority;

    private bool $is_main;

    private bool $is_complete;

    private ?\DateTimeImmutable $created_at;

    #[Assert\NotBlank]
    private int $type;
    #[Assert\NotBlank]
    private Uuid $user_uuid;

    public function __construct($entityData)
    {
        $this->uuid = Uuid::v4();
        $this->setName($entityData['name'] ?? null);
        $this->setPriority($entityData['priority'] ?? null);
        $this->setIsMain($entityData['is_main'] ?? null);
        $this->setComplete($entityData['is_complete'] ?? null);
        $this->setType($entityData['type'] ?? null);
        $this->setCreatedAt(new \DateTimeImmutable());
        $this->setUserUuid(Uuid::fromString($entityData['user_uuid']) ?? null);
        parent::__construct($this->toArray());
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getPriority(): string
    {
        return $this->priority;
    }

    public function setPriority(string $priority): self
    {
        $this->priority = $priority;
        return $this;
    }

    public function getIsMain(): bool
    {
        return $this->is_main;
    }

    public function setIsMain(bool $is_main): self
    {
        $this->is_main = $is_main;
        return $this;
    }

    public function getIsComplete(): bool
    {
        return $this->is_complete;
    }

    public function setComplete(bool $is_complete): self
    {
        $this->is_complete = $is_complete;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(): self
    {
        $this->created_at = new \DateTimeImmutable();
        return $this;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getUserUuid(): Uuid
    {
        return $this->user_uuid;
    }

    public function setUserUuid(Uuid $user_uuid): self
    {
        $this->user_uuid = $user_uuid;
        return $this;
    }
}