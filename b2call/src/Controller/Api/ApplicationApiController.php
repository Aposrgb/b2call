<?php


namespace App\Controller\Api;

use App\Entity\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Response;
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
     *              ref=@Model(type=Application::class, groups={"show_app"})
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

    #[Route('', name: 'create_full_application', methods: ['POST'])]
    /**
     * Создание или редактирование заявки
     *
     * @OA\Parameter (
     *     name="id",
     *     in="query",
     *     required=false,
     *     description="id редактируемой заявки"
     * )
     *
     * @OA\RequestBody  (
     *     required=true,
     *     @OA\JsonContent(
     *          @OA\Property(property="service", type="string", example="Услуга"),
     *          @OA\Property(property="source", type="string", example="Источник"),
     *          @OA\Property(property="space", type="string", example="Необходимое пространство"),
     *          @OA\Property(property="room", type="string", example="Назначение помещения"),
     *          @OA\Property(property="typeRoom", type="string", example="Тип помещения"),
     *          @OA\Property(property="floorFrom", type="integer", description="Этаж от"),
     *          @OA\Property(property="floorTo", type="integer", description="Этаж до"),
     *          @OA\Property(property="builtFrom", type="integer", description="Построен от"),
     *          @OA\Property(property="builtTo", type="integer", description="Построен до"),
     *          @OA\Property(property="typeBuilding", type="string", example="тип здания"),
     *          @OA\Property(property="entrance", type="string", example="вход"),
     *          @OA\Property(property="furnitureAvailable", type="boolean", description="наличие мебели"),
     *          @OA\Property(property="conditioner", type="boolean", description="кондиционер"),
     *          @OA\Property(property="heating", type="boolean", description="отопление"),
     *          @OA\Property(property="internet", type="boolean", description="интернет"),
     *          @OA\Property(property="kitchen", type="boolean", description="кухня"),
     *          @OA\Property(property="entrancePrivate", type="boolean", description="отдельный вход")
     *     )
     * )
     *
     * @OA\Response(
     *     response="200",
     *     description="Создана заявка",
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
        $id = $request->get("id", null);
        $application = $this->entityManager->getRepository(Application::class)->findOneBy(['id' => $id]);
        if(!$application && $id)
            throw new ApiException('Not found application', status: Response::HTTP_NOT_FOUND);
        elseif ($application){
            $data = $this->serializer->deserialize($request->getContent(), Application::class, "json");
            $application->setService($data->getService() ?? $application->getService());
            $application->setEntrance($data->getEntrance() ?? $application->getEntrance());
            $application->setConditioner($data->getConditioner() ?? $application->getConditioner());
            $application->setTypeRoom($data->getTypeRoom() ?? $application->getTypeRoom());
            $application->setBuiltTo($data->getBuiltTo() ?? $application->getBuiltTo());
            $application->setBuiltFrom($data->getBuiltFrom() ?? $application->getBuiltFrom());
            $application->setSource($data->getSource() ?? $application->getSource());
            $application->setSpace($data->getSpace() ?? $application->getSpace());
            $application->setRoom($data->getRoom() ?? $application->getRoom());
            $application->setFloorFrom($data->getFloorFrom() ?? $application->getFloorFrom());
            $application->setFloorTo($data->getFloorTo() ?? $application->getFloorTo());
            $application->setTypeBuilding($data->getTypeBuilding() ?? $application->getTypeBuilding());
            $application->setEntrance($data->getEntrance() ?? $application->getEntrance());
            $application->setFurnitureAvailable($data->getFurnitureAvailable() ?? $application->getFurnitureAvailable());
            $application->setHeating($data->getHeating() ?? $application->getHeating());
            $application->setInternet($data->getInternet() ?? $application->getInternet());
            $application->setKitchen($data->getKitchen() ?? $application->getKitchen());
            $application->setEntrancePrivate($data->getEntrancePrivate() ?? $application->getEntrancePrivate());
        }else{
            $application = $this->serializer->deserialize($request->getContent(), Application::class, "json");
            $this->entityManager->persist($application);
        }
        $this->entityManager->flush();
        return $this->json(['data' => $application->getId()]);
    }

}