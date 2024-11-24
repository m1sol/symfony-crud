<?php

namespace App\Serializer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Message\TaskCreatedEvent;

class TaskCreatedEventNormalizer implements NormalizerInterface
{
    public function normalize(mixed $object, ?string $format = null, array $context = []): array|string|int|float|bool|null
    {
        if (!$object instanceof TaskCreatedEvent) {
            throw new \InvalidArgumentException('Object must be of type TaskCreatedEvent');
        }

        return [
            'task_uuid' => $object->getTaskUuid()->toRfc4122(),
            'user_uuid' => $object->getUserUuid()->toRfc4122(),
        ];
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof TaskCreatedEvent;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            TaskCreatedEvent::class => true,
        ];
    }
}
