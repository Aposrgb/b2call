<?php


namespace App\EventListener;


use App\Helper\Exception\ApiException;
use App\Helper\Exception\ResponseCode;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelInterface;

class ExceptionListener
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    private string $environment;

    public function __construct(LoggerInterface $logger, KernelInterface $kernel)
    {
        $this->logger = $logger;
        $this->environment = $kernel->getEnvironment();
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        // You get the exception object from the received event
        $exception = $event->getThrowable();
        $this->logger->error($exception->getMessage(), $exception->getTrace());
        $apiException = $exception;
        if (!$exception instanceof ApiException) {
            $statusCode = method_exists($exception, 'getStatusCode') ?
                $exception->getStatusCode() :
                Response::HTTP_INTERNAL_SERVER_ERROR;

            $apiException = new ApiException(
                ResponseCode::getStatusTexts()[$statusCode] ?? null,
                $this->environment === 'dev' ? $exception->getMessage() : null,
                $statusCode,
                [],
            );
        }
        $errorJsonResponse = new JsonResponse($apiException->responseBody(), $apiException->getStatusCode());
        $event->setResponse($errorJsonResponse);
    }

}