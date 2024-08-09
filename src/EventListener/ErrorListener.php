<?php

namespace App\EventListener;

use App\Exception\ValidationException;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ErrorListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $response = match (true) {
            $exception instanceof ValidationException => new JsonResponse(
                ['errors' => $exception->getErrors()],
                Response::HTTP_BAD_REQUEST
            ),
            $exception instanceof NotFoundHttpException => new JsonResponse(
                ['error' => $exception->getMessage()],
                Response::HTTP_NOT_FOUND
            ),
            $exception instanceof InvalidArgumentException => new JsonResponse(
                ['error' => $exception->getMessage()],
                Response::HTTP_BAD_REQUEST
            ),
            default => null,
        };

        if ($response) {
            $event->setResponse($response);
        }
    }
}
