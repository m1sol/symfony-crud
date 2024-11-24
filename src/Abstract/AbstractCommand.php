<?php

namespace App\Abstract;

use App\Contract\CommandInterface;

abstract class AbstractCommand implements CommandInterface
{
    protected $entityData;

    public function __construct(array $entityData)
    {
        $this->entityData = $entityData;
    }

    public function getEntityData(): array
    {
        $entityData = $this->entityData ?? [];

        // Убедитесь, что возвращается именно массив, даже если данных пока нет
        return is_array($entityData) ? $entityData : [];
    }

    public function toArray(): array
    {
        $data = [];
        $reflectionClass = new \ReflectionClass($this);

        // Проходим по всем методам класса
        foreach ($reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            // Ищем методы-геттеры, начинающиеся с 'get'
            if (strpos($method->getName(), 'get') === 0 && $method->getName() !== 'getEntityData') {
                // Получаем название свойства из геттера и преобразуем в snake_case
                $property = lcfirst(substr($method->getName(), 3));
                $snakeCaseProperty = $this->camelToSnake($property);

                $data[$snakeCaseProperty] = $method->invoke($this);
            }
        }

        return $data;
    }

    private function camelToSnake(string $input): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
    }
}