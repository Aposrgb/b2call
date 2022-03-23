<?php


namespace App\Controller\Api;

use App\Entity\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use App\Helper\Exception\ApiException;

#[Route('/application')]
/**
 * @OA\Tag(name="Заявки")
 */
class ApplicationApiController extends AbstractApiController
{
    #[Route('/{id}', name: 'get_application', methods: ['GET'])]
    /**
     * Получение заявки
     *
     * @OA\Response(
     *     response="200",
     *     description="Заявка",
     *     @OA\JsonContent(
     *          @OA\Property(property="data", type="object",
     *              ref=@Model(type=Application::class)
     *          )
     *     )
     * )
     * @OA\Response(
     *     response="404",
     *     description="Application Not Found",
     *     @Model(type=ApiException::class, groups={"show"}),
     * )
     *
     */
    public function getApplication(Application $application): JsonResponse
    {
        return $this->json(['data' => $application], context: ["groups" => ["show_app"]]);
    }

    #[Route('', name: 'create_application', methods: ['POST'])]
    /**
     * Создание заявки c общей информацией
     *
     * @OA\RequestBody  (
     *     required=true,
     *     @OA\JsonContent(
     *          @OA\Property(property="service", type="string", example="Услуга"),
     *          @OA\Property(property="source", type="string", example="Источник"),
     *          @OA\Property(property="space", type="string", example="Необходимое пространство"),
     *          @OA\Property(property="room", type="string", example="Назначение помещения"),
     *          @OA\Property(property="typeRoom", type="string", example="Тип помещения")
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
    public function createApplication(Request $request): JsonResponse
    {
        $application = $this->serializer->deserialize($request->getContent(), Application::class, "json");
        $this->entityManager->getRepository(Application::class)->add($application, true);
        return $this->json(['data' => $application->getId()]);
    }

    #[Route('', name: 'create_full_application', methods: ['POST'])]
    /**
     * Создание заявки c полной информацией
     *
     * @OA\RequestBody  (
     *     required=true,
     *     @OA\JsonContent(
     *          @OA\Property(property="service", type="string", example="Услуга"),
     *          @OA\Property(property="source", type="string", example="Источник"),
     *          @OA\Property(property="space", type="string", example="Необходимое пространство"),
     *          @OA\Property(property="room", type="string", example="Назначение помещения"),
     *          @OA\Property(property="typeRoom", type="string", example="Тип помещения"),
     *          @OA\Property(property="floorFrom", type="integer", example="Этаж от),
     *          @OA\Property(property="floorTo", type="integer", example="Этаж до"),
     *          @OA\Property(property="builtFrom", type="integer", example="Построен от"),
     *          @OA\Property(property="builtTo", type="integer", example="Построен до"),
     *          @OA\Property(property="typeBuilding", type="string", example="тип здания"),
     *          @OA\Property(property="entrance", type="string", example="вход"),
     *          @OA\Property(property="furnitureAvailable", type="boolean", example="false, наличие мебели"),
     *          @OA\Property(property="conditioner", type="boolean", example="false, кондиционер"),
     *          @OA\Property(property="heating", type="boolean", example="false, отопление")
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
    public function createFullApplication(Request $request): JsonResponse
    {
        $application = $this->serializer->deserialize($request->getContent(), Application::class, "json");
        $this->entityManager->getRepository(Application::class)->add($application, true);
        return $this->json(['data' => $application->getId()]);
    }
}