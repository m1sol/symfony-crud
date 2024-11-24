<?php

namespace App\Contract;

interface RepositoryInterface
{
    public function save(object $entity): void;
    public function delete(object $entity): void;
}