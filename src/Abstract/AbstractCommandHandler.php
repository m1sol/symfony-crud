<?php

namespace App\Abstract;

use App\Contract\CommandInterface;
use Symfony\Component\Uid\Uuid;

abstract class AbstractCommandHandler
{

    abstract public function handleCreate(CommandInterface $command);

    abstract public function handleUpdate(Uuid $uuid, CommandInterface $command);

    abstract public function handleDelete(Uuid $uuid);
}