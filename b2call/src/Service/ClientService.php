<?php

namespace App\Service;

use App\Entity\Device;
use App\Helper\Exception\ApiExceptionHandler;
use App\Helper\Status\ClientStatus;
use App\Helper\Status\DeviceStatus;
use Symfony\Component\HttpFoundation\Response;

class ClientService extends AbstractService
{
    public function checkToken($token)
    {
        if ($token == null) {
            ApiExceptionHandler::errorApiHandlerMessage(null, 'Invalid API Token');
        }
        /** @var Device $device */
        $device = $this->entityManager->getRepository(Device::class)->findOneBy([
            'token' => $token,
            'status' => DeviceStatus::ACTIVE,
        ]);
        if (!$device) {
            ApiExceptionHandler::errorApiHandlerMessage(
                'Ошибка аутентификации',
                'Auth Invalid Token',
                Response::HTTP_UNAUTHORIZED
            );
        }
        $client = $device->getClient();

        if ($client->getStatus() == ClientStatus::BLOCK) {
            $device->setStatus(DeviceStatus::BLOCK);
            $this->entityManager->flush();
            ApiExceptionHandler::errorApiHandlerMessage(
                'Ошибка аутентификации',
                'Auth Invalid Token',
                Response::HTTP_UNAUTHORIZED
            );
        }
        if ($device->getDateExpires() < new \DateTime()) {
            $device->setStatus(DeviceStatus::ARCHIVE);
            $this->entityManager->flush();
            ApiExceptionHandler::errorApiHandlerMessage(
                'Ошибка аутентификации',
                'Auth Invalid Token',
                Response::HTTP_UNAUTHORIZED
            );
        }
        $this->entityManager->flush();
        return $device->getClient();
    }

}
