<?php


namespace App\Controller\Api;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

abstract class AbstractApiController extends AbstractController
{
    public function __construct(
        protected SerializerInterface $serializer,
        protected EntityManagerInterface $entityManager,
        protected DenormalizerInterface $denormalizer
    )
    {
    }

    /**
     * @param $data
     * @param int $code
     * @param array $headers
     * @return Response
     */
    protected function createResponse($data, $code = 200, $headers = [])
    {
        $response = new Response($data, $code, $headers);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


}