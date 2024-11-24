<?php

namespace App\Controller\Api;

use App\Cqrs\Command\CreateGoalsCommand;
use App\Cqrs\Handler\GoalsCommandHandler;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateGoalsController
{

    #[Route('/api/goals/create', name: 'goals_create', methods: ['POST'])]
    #[OA\Tag(name: 'Goals')]
    #[OA\Post(summary: 'Создание цели')]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            properties: [
                new OA\Property('name', type: 'string'),
                new OA\Property('priority', type: 'int'),
                new OA\Property('is_main', type: 'boolean'),
                new OA\Property('is_complete', type: 'boolean'),
                new OA\Property('type', type: 'int'),
            ],
            type: 'object',
            example: [
                'name' => 'New Goal',
                'priority' => 1,
                'is_main' => true,
                'is_complete' => false,
                'type' => 2,
            ]
        )
    )]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Возвращается ID созданной цели',
        content: new OA\JsonContent(
            properties: [
                new OA\Property('id', type: 'integer'),
            ],
            type: 'object',
            example: [
                'uuid' => 14554,
            ]
        )
    )]

    public function createGoal(Request $request, GoalsCommandHandler $goalsCommandHandler): Response
    {
        // Получаем данные из запроса
        $data = json_decode($request->getContent(), true);
        $createGoalsCommand = new CreateGoalsCommand($data);
        $goalsCommandHandler->handleCreate($createGoalsCommand);

        return new Response('Goal created successfully!', Response::HTTP_CREATED);
    }
}