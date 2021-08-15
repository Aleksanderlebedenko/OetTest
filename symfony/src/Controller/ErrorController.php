<?php


namespace App\Controller;


use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;

class ErrorController
{
    private const UNEXPECTED_ERROR_MESSAGE = 'Something went wrong';

    public function show(
        Request $request,
        FlattenException $exception,
        DebugLoggerInterface $logger = null): JsonResponse
    {
        $message = $exception->getMessage();
        if ($exception->getStatusCode() >= Response::HTTP_INTERNAL_SERVER_ERROR) {
            $message = self::UNEXPECTED_ERROR_MESSAGE;
            //TODO: log error.
        }
        return new JsonResponse([
            'message' => $message,
        ], $exception->getStatusCode());
    }
}