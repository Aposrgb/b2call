<?php


namespace App\Controller\Api;

use App\Entity\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use App\Helper\Exception\ApiException;
use App\Entity\Client;

#[Route('/client')]
/**
 * @OA\Tag(name="Клиент")
 */
class ClientApiController extends AbstractApiController
{
    #[Route('/{id}', name: 'get_client', methods: ['GET'])]
    /**
     * Получение клиента
     *
     * @OA\Response(
     *     response="404",
     *     description="Application Not Found",
     *     @Model(type=ApiException::class, groups={"show"})
     * )
     */
    public function getClient(Client $client): JsonResponse
    {
        return $this->json($client, context: ["groups" => ["show"], "normalize" => "normalizeClient"]);
    }

    #[Route('', name: 'create_client', methods: ['POST'])]
    /**
     * Создание клиента
     *
     * @OA\RequestBody  (
     *     required=true,
     *     @OA\JsonContent(
     *          @OA\Property(property="firstname", type="string"),
     *          @OA\Property(property="lastname", type="string"),
     *          @OA\Property(property="patronymic", type="string"),
     *          @OA\Property(property="mail", type="string"),
     *          @OA\Property(property="phone", type="string")
     *     )
     * )
     *
     * @OA\Response(
     *     response="200",
     *     description="Создано",
     *     @OA\JsonContent(
     *          @OA\Property(property="data", type="object",
     *              @OA\Property(property="id", type="integer")
     *          )
     *     )
     * )
     *
     */
    public function createClient(Request $request): JsonResponse
    {
        $client = $this->serializer->deserialize($request->getContent(), Client::class, "json");
        $this->entityManager->getRepository(Client::class)->add($client, true);
        return $this->json(['data' => $client->getId()]);
    }

    #[Route('/{id}/application', name: 'add_app_client', methods: ['POST'])]
    /**
     * Добавление заявки клиенту
     *
     * @OA\RequestBody  (
     *     required=true,
     *     @OA\JsonContent(
     *          @OA\Property(property="id", type="integer", example="id заявки")
     *     )
     * )
     *
     * @OA\Response(
     *     response="200",
     *     description="Создано",
     *     @OA\JsonContent(
     *          @OA\Property(property="data", type="object",
     *              @OA\Property(property="id", type="integer")
     *          )
     *     )
     * )
     * @OA\Parameter(
     *     name = "id",
     *     in = "path",
     *     description = "id - клиента",
     *     required="true",
     *     @OA\Schema (type="integer")
     * )
     *
     */
    public function addAppClient(Client $client, Request $request): JsonResponse
    {
        $id = json_decode($request->getContent(), true)['id'] ?? null;
        $app = $this->entityManager->getRepository(Application::class)->findOneBy(['id' => $id]);
        if ($app) {
            $client->addApplication($app);
            $this->entityManager->flush();
        }
        return $this->json(['data' => $client->getId()]);
    }
}