<?php

namespace App\Contract;

interface CommandInterface
{
    public function getEntityData(): array;
}