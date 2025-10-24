<?php

namespace App\EventListener;

use App\Exception\ValidationException;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $response = match (true) {
            $exception instanceof ValidationException => new JsonResponse(
                ['errors' => $exception->getErrors()],
                Response::HTTP_BAD_REQUEST
            ),
            $exception instanceof ValidationFailedException => new JsonResponse(
                ['errors' => $this->formatValidationErrors($exception)],
                Response::HTTP_UNPROCESSABLE_ENTITY
            ),
            $exception instanceof UnprocessableEntityHttpException => new JsonResponse(
                ['errors' => [$exception->getMessage()]],
                Response::HTTP_UNPROCESSABLE_ENTITY
            ),
            $exception instanceof NotFoundHttpException,
            $exception instanceof MethodNotAllowedHttpException => new JsonResponse(
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

    private function formatValidationErrors(ValidationFailedException $exception): array
    {
        $errors = [];
        foreach ($exception->getViolations() as $violation) {
            $propertyPath = $violation->getPropertyPath();
            if (!isset($errors[$propertyPath])) {
                $errors[$propertyPath] = [];
            }
            $errors[$propertyPath][] = $violation->getMessage();
        }
        return $errors;
    }
}
