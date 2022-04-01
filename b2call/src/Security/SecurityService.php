<?php

namespace App\Security;

use App\Entity\Client;
use App\Entity\Device;
use App\Helper\Exception\ApiException;
use App\Helper\Status\ClientStatus;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\Response;

class SecurityService extends AbstractService
{
    public function login($body)
    {
        /** @var Client $client */
        $client = $this
            ->entityManager
            ->getRepository(Client::class)
            ->findOneBy(['mail' => $body->getMail()]);
        $password = $client && $this->hasher->isPasswordValid($client, $body->getPassword());

        if(!$password)
            throw new ApiException(message: "Email or password incorrect", code: Response::HTTP_BAD_REQUEST);
        switch ($client->getStatus()){
            case ClientStatus::APPROVED:
                throw new ApiException(message: "Your account not approved", code: Response::HTTP_BAD_REQUEST);
            case ClientStatus::ARCHIVE:
                throw new ApiException(message: "Your account not found", code: Response::HTTP_BAD_REQUEST);
        }

        $device = new Device();
        $client->addDevice($device);

        $this->entityManager->flush();
        return $device->getToken();
    }

}