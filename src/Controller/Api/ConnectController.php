<?php
namespace App\Controller\Api;

use App\Cqrs\Command\CreateGoalsCommand;
use App\Cqrs\Handler\GoalsCommandHandler;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ConnectController
{

    #[Route('/bot-sotis/city', name: 'city', methods: ['POST'])]
    #[OA\Tag(name: 'Goals')]
    #[OA\Post(summary: 'Создание цели')]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            properties: [
                new OA\Property('city', type: 'string'),
            ],
            type: 'object',
            example: [
                'name' => 'Armavir'
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
//        $data = json_decode($request->getContent(), true);
//        $createGoalsCommand = new CreateGoalsCommand($data);
//        $goalsCommandHandler->handleCreate($createGoalsCommand);

        return new JsonResponse(
            ['cities' => ['Кранодар', 'Кранодар2']],
            Response::HTTP_CREATED
        );
    }
}