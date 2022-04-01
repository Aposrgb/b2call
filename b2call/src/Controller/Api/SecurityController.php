<?php

namespace App\Controller\Api;

use App\Entity\Client;
use App\Security\SecurityService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(name="Безопасность")
 */
class SecurityController extends AbstractApiController
{
    #[Route('/login', name: 'login', methods: ['POST'])]
    /**
     * Вход
     * @OA\RequestBody  (
     *     required=true,
     *     @OA\JsonContent(
     *          @OA\Property(property="mail", type="string"),
     *          @OA\Property(property="password", type="string")
     *     )
     * )
     * @OA\Response(
     *     response="200",
     *     description="Клиент",
     *     @OA\JsonContent(
     *          @OA\Property(property="data", type="object",
     *              @OA\Property(property="token", type="string")
     *          )
     *     )
     * )
     *
     */
    public function login(Request $request, SecurityService $securityService)
    {
        $body = $this->serializer->deserialize($request->getContent(), Client::class, "json");
        $token = $securityService->login($body);
        return $this->json(["data" => ["token" => $token]]);
    }
}